<?php
    require_once "config.php";
    include_once "classes.php";
    session_start();
    $user_id = $_SESSION['id'];
    $output = '';
    $followers = [];
    $FRIENDS = new Friends();
    $friends = [];
    $following = [];
    $followers = [];
    $DB = new DB();

    /** Get friends i.e People that are being followed or following */
    /** Getting Followers */
    
    $followers = $FRIENDS->get_friends($user_id,"followers");


    /** Getting Following */
    $following = $FRIENDS->get_friends($user_id,"following");


    $sql = "SELECT * FROM users WHERE NOT user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"s",$user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while($row = mysqli_fetch_assoc($result)){

            /** Get Only friends Here */
            if(in_array($row['user_id'],$following) || in_array($row['user_id'],$followers) )
            {
                $sub = "SELECT * FROM chats WHERE (incoming_id = '{$user_id}' AND outgoing_id = '{$row['user_id']}') ORDER BY msg_id DESC";
                $chats = $DB->read($sub);
                $no_of_chats = 0;
                if($chats){
                    foreach ($chats as $chat) {
                        if($chat['read_status'] == 0){
                            $no_of_chats = $no_of_chats + 1;
                        }
                    }
                }
                
                
                $sql2 = "SELECT * FROM chats WHERE (incoming_id = '{$row['user_id']}' AND outgoing_id = '{$user_id}') OR (incoming_id = '{$user_id}' AND outgoing_id = '{$row['user_id']}') ORDER BY msg_id DESC LIMIT 1";
                $result2 = mysqli_query($conn,$sql2);
                $read = 0;
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


                    if($no_of_chats == 0)
                    {
                        $no_message = "";
                    }else{
                        $no_message = '<span style="width:30px;color:#fff;
                        height:30px;display:flex;
                        background:#f00;justify-content:center;
                        font-size:.9rem;align-items:center;
                        position:absolute;border-radius:50%; 
                        top:0;right:0;transform:translate(20%, -20%);">'.$no_of_chats.'</span>';

                    }
                    
                    if($row['status'] == "offline"){
                        $status = '';
                    }else{
                        $status = '<i class="fa fa-star" style="font-size:1rem;color:#0f0;position:absolute; top:50%;right:10px;transform:translateY(-50%)"></i>';
                    }

                    if($row2['outgoing_id'] == $user_id){
                        $diff = '<p class="text-muted" style="color:#fff"><span style="font-weight:bold;color:red;">You: </span>'.$result3.'</p>';
                    }else{
                        $diff = '<p class="text-muted" style="'.$bold.'" >'.$result3.'</p>';
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
                    $result3 = "No message available";
                    
                    if($row['status'] == "offline"){
                        $status = '';
                    }else{
                        $status = '<i class="fa fa-star" style="font-size:.8rem;color:#0f0;position:absolute; top:50%;right:10px;transform:translateY(-50%)"></i>';
                    }
                        

                    $output .= 
                        '   <a href="./chat_page.php?id='.$row['user_id'].'" class="user_link" style="position:relative">
                            <div class="user">
                                <div class="profile-pic">
                                    <img src="./includes/'.$row['profile_pic'].'">
                                </div>
                                
                                <div class="details" style="position:relative">
                                    <h5 class="user-name">'.$row['username'].'</h5>
                                    <p class="text-muted">'.$result3.'</p>
                                </div>
                            </div>
                            '.$status.'
                        </a>
                    ';
                    

                }
            }

        }
        echo $output;
        // var_dump($row);

    }else{
        echo "Something Wrong";
        header('location:../login.php');
        die();
    }