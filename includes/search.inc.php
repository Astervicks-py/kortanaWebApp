<?php
require "config.php";
require "classes.php";
session_start();
$id = $_SESSION['id'];
$DB = new DB();
$user = new User();
$friends = new Friends();
$user_cls = new User();
$followers_ids = $friends->get_friends($id,"followers");
$following_ids = $friends->get_friends($id,"following");
$friends_ids = $friends->get_friends($id,"friends");
$output = "";
$section =  strtolower(mysqli_real_escape_string($conn,(addslashes($_POST['section']))));
$search =  strtolower(mysqli_real_escape_string($conn,(addslashes($_POST["searchTerm"]))));


$sql = "SELECT * FROM users WHERE fname LIKE '%$search%' OR lname LIKE '%$search%' OR username LIKE '%$search%' LIMIT 10";

$script = 
'
<script>

    function $(element){
        return document.querySelector(element);
    }
    function follow(e,elem) {
        e.preventDefault();
        var link = elem.href;
        if(elem.textContent == "Follow")
        {
            elem.textContent = "Unfollow";
        }else if(elem.textContent == "Follow Back")
        {
            elem.textContent = "Unfollow";
        }else{
            elem.textContent = "Follow";
        }
        // console.log(link);
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./includes/outside_follow.inc.php",true);
        xhr.onload = () =>
        {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
            {
                let data = xhr.response;
                console.log(data);
                
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("link=" + link);
    }

</script>


';
$result = $DB->read($sql);
if($result)
{
    if($section == "kfamily" || $section == "desiree" || $section == "friend")
    {
        if($section == "friend"){
            foreach ($result as $row) {
                /** Check iof the found User is a frined or foe */
                if($row['status'] == "offline"){
                    $status = '';
                }else{
                    $status = '<i class="fa fa-star" style="font-size:1rem;color:#0f0;position:absolute; top:50%;right:10px;transform:translateY(-50%)"></i>';
                }

                if(in_array($row['user_id'],$followers_ids) && in_array($row['user_id'],$following_ids))
                {
                    $sub = "SELECT * FROM chats WHERE (incoming_id = '{$id}' AND outgoing_id = '{$row['user_id']}') ORDER BY msg_id DESC";
                    $chats = $DB->read($sub);
                    $no_of_chats = 0;
                    if($chats){
                        foreach ($chats as $chat) {
                            if($chat['read_status'] == 0){
                                $no_of_chats = $no_of_chats + 1;
                            }
                        }
                    }
                    
                    
                    $sql2 = "SELECT * FROM chats WHERE (incoming_id = '{$row['user_id']}' AND outgoing_id = '{$id}') OR (incoming_id = '{$id}' AND outgoing_id = '{$row['user_id']}') ORDER BY msg_id DESC LIMIT 1";
                    $result2 = mysqli_query($conn,$sql2);
                    $read = 0;

                    $bold = "";
                    $no_message = "";
                    $result3 = "No message available";
                    $diff = '<p class="text-muted" style="'.$bold.'" >'.$result3.'</p>';
                    if(mysqli_num_rows($result2) > 0){
                        $row2 = mysqli_fetch_assoc($result2);
                        
                        if($row2['read_status'] == 1){
                            $bold = "color:#fff;";
                        }else{
                            $bold = "color:#0f0; font-weight:bold;";
                        }


                        if(strlen($row2['message']) > 20){
                            $result3 = substr($row2['message'],0,20).'...';
                        }else{
                            $result3 = $row2['message'];
                        }


                        if($no_of_chats > 0)
                        {
                            $no_message = '<span style="width:30px;color:#fff;
                            height:30px;display:flex;
                            background:#f00;justify-content:center;
                            font-size:.9rem;align-items:center;
                            position:absolute;border-radius:50%; 
                            top:0;right:0;transform:translate(20%, -20%);">'.$no_of_chats.'</span>';

                        }
                        
                        

                        if($row2['outgoing_id'] == $id){
                            $diff = '<p class="text-muted" style="color:#fff"><span style="font-weight:bold;color:red;">You: </span>'.$result3.'</p>';
                        }
        
                            
                    }else{
                        $result3 = "No message available";
                    }

                    

                    $output .= 
                        '   <a href="./chat_page.php?id='.$row['user_id'].'" class="user_link" style="position:relative">
                                <div class="user">
                                    <div class="profile-pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    
                                    <div class="details" style="position:relative">
                                        <h5 class="user-name">'.$row['username'].'</h5>
                                        '.$diff.'
                                    </div>
                                </div>
                                '.$no_message.'
                                '.$status.'
                            </a>
                        ';
                }else{
                    $output .= 
                    '   <div class="user_link" style="position:relative">
                            <div class="user">
                                <div class="profile-pic">
                                    <img src="./includes/'.$row['profile_pic'].'">
                                </div>
                                
                                <a href="friends_profile_page.php?id='.$row['user_id'].'" class="details" style="position:relative">
                                    <h5 class="user-name">'.$row['username'].'</h5>
                                    <p style="color:#f00">Follow each other to chat 😏</p>
                                </a>
                            </div>
                            '.$status.'
                        </a>
                    ';
                }

                
                
            }
        }


        else if($section == "desiree")
        {
            foreach($result as $row){
                
                if(in_array($row['user_id'],$followers_ids) && !in_array($row['user_id'],$following_ids))
                {
                    $output .= '
                        <div class="friend">
                            <a href="./friends_profile_page.php?id='.$row['user_id'].'" class="top">
                                <img class="profile_pic" src="./includes/'.$row['profile_pic'].'">
                                <div class="friend-name">
                                    <h4>'.$row['username'].'</h4>
                                    <h5 style="display:inline-block;margin-right:8px">'.$row['followers'].' Followers</h5>
                                    <h5 style="display:inline-block;margin-right:8px">Following '.$row['following'].'</h5>
                                </div>
                            </a>
                            <div class="bottom">
                                <a onclick="follow(event,this)" href="'. $row['user_id'] .'" >Follow Back</a>
                            </div>
                        </div>
                    
                    ';
                }
                
            }  
        }else{
            foreach($result as $row){
            
                $output .= '
                    <div class="friend">
                        <a href="./friends_profile_page.php?id='.$row['user_id'].'" class="top">
                            <img class="profile_pic" src="./includes/'.$row['profile_pic'].'">
                            <div class="friend-name">
                                <h4>'.$row['username'].'</h4>
                                <h5 style="display:inline-block;margin-right:8px">'.$row['followers'].' Followers</h5>
                                <h5 style="display:inline-block;margin-right:8px">Following '.$row['following'].'</h5>
                            </div>
                        </a>
                        <div class="bottom">
                            <a onclick="follow(event,this)" href="'. $row['user_id'] .'" >Follow</a>
                        </div>
                    </div>
                
                ';
            }
                
        }
       
    }

    else {
        $output = "NOTHING";
    }
    
    
}else
{
    $output = "<h2 style='color:#fff;text-align:center'>N0 K-FAMILY MATCHED 😕<h2>";
    if($section == "desiree")
    {
        $output = "<h2 style='color:#fff;text-align:center'>NO DESIREE MATCHED 😕</h2>";
    }
    if($section == "friend")
    {
        $output = "<h2 style='color:#fff;width:100%;text-align:center'>NO FRIENDS FOUND 😕</h2>";
    }
    
}

echo $output;
// var_dump($result);
