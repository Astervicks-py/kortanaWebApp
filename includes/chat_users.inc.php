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
    $user_data = new User();

    /** Get friends i.e People that are being followed or following */
    /** Getting Followers */
    
    $followers = $FRIENDS->get_friends($user_id,"followers");


    /** Getting Following */
    $following = $FRIENDS->get_friends($user_id,"following");



    /**
     * another approach
     */

    $sql = "SELECT history FROM users WHERE user_id = '$user_id'";
    if($result = $DB->read($sql))
    {
        $result = $result[0]['history'];
        if(!is_null($result))
        {
            $history = json_decode($result,true);
            if(is_array($history))
            {
                // print_r($history);
                // die();
                foreach ($history as $user) {

                    /**
                     * Get number of chats
                     */
                    $sub = "SELECT * FROM chats WHERE (incoming_id = '{$user_id}' AND outgoing_id = '{$user}') ORDER BY msg_id DESC";
                    $chats = $DB->read($sub);
                    $no_of_chats = 0;
                    if($chats){
                        foreach ($chats as $chat) {
                            if($chat['read_status'] == 0){
                                $no_of_chats = $no_of_chats + 1;
                            }
                        }
                    }

                    

                    $sql = "SELECT * FROM chats WHERE (incoming_id = '{$user}' AND outgoing_id = '{$user_id}') OR (incoming_id = '{$user_id}' AND outgoing_id = '{$user}') ORDER BY msg_id DESC LIMIT 1";
                    if($result = $DB->read($sql))
                    {
                        $result = $result[0]; 
                        if($result['read_status'] == 1){
                            $bold = "color:#fff;";
                        }else{
                            $bold = "color:#0f0; font-weight:bold;";
                        }

                        if(strlen($result['message']) > 20){
                            $message = substr($result['message'],0,20).'...';
                        }else{
                            $message = $result['message'];
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

                        /** Checking status */
                        $status_result =$user_data->user_data($user)[0]['status'];
                        if($status_result == "offline"){
                            $status = '';
                        }else{
                            $status = '<i class="fa fa-star" style="font-size:1rem;color:#0f0;position:absolute; top:50%;right:10px;transform:translateY(-50%)"></i>';
                        }

                        if($result['outgoing_id'] == $user_id){
                            $diff = '<p class="text-muted" style="color:#fff"><span style="font-weight:bold;color:red;">You: </span>'.$message.'</p>';
                        }else{
                            $diff = '<p class="text-muted" style="'.$bold.'" >'.$message.'</p>';
                        }
                        /** Getting the user data of individual user */
                        $row = $user_data->user_data($user)[0];
                        
                        $is_verifed = $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "";
                        $output .= 
                        '   <a href="./chat_page.php?id='.$row['user_id'].'" class="user_link" style="position:relative">
                                <div class="user">
                                    <div class="profile-pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    
                                    <div class="details" style="position:relative">
                                        <h5 style="display:flex;gap:5px;" class="user-name">'.$row['username']. $is_verifed .'</h5>
                                        '.$diff.'
                                    </div>
                                </div>
                                '.$no_message.'
                                '.$status.'
                            </a>
                        ';
                        
                    }

                    
                }

                /**
                 * Adding users followed after the ones messaged;
                */

                foreach ($following as $user) {
                    if(!in_array($user,$history))
                    {
                        /** Getting the user data of individual following */
                        
                        // die();
                        $row = $user_data->user_data($user);
                        if($row)
                        {
                            $row = $row[0];
                        }
                        // var_dump($row);
                        $message = "No message available";
                    
                         /** Checking status */
                         $status_result =$user_data->user_data($user)[0]['status'];
                        // var_dump( $status_result =$user_data->user_data($user));
                        if($status_result == "offline"){
                            $status = '';
                        }else{
                            $status = '<i class="fa fa-star" style="font-size:1rem;color:#0f0;position:absolute; top:50%;right:10px;transform:translateY(-50%)"></i>';
                        }
                            

                        $output .= 
                            '   <a href="./chat_page.php?id='.$row['user_id'].'" class="user_link" style="position:relative">
                                <div class="user">
                                    <div class="profile-pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    
                                    <div class="details" style="position:relative">
                                        <h5 class="user-name">'.$row['username'].'</h5>
                                        <p class="text-muted">'.$message.'</p>
                                    </div>
                                </div>
                                '.$status.'
                            </a>
                        ';
                    }
                }

                echo $output;
            }
        }
    }else{
        echo "Something Went Wrong";
        header('location:../login.php');
        die();
    }