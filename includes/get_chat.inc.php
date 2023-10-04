<?php
    session_start();
    require_once "config.php";
    require_once "classes.php";
    $DB = new DB();
    
    // var_dump($chat_setting);
    // die();
    if(isset($_POST['incoming_id'])){
        $needed_id = $_SESSION['id'];
        $chat_set_sql = "SELECT * FROM chat_setting WHERE user_id = '$needed_id'";
        $chat_setting = $DB->read($chat_set_sql)[0];
        $incoming_id = $_POST['incoming_id'];
        $outgoing_id = $_SESSION['id'];
        $output = '';
        $sub = "SELECT status FROM users WHERE user_id = '$incoming_id'";
        $check = $DB->read($sub)[0];
        $status = $check['status'];
        $sql = "SELECT * FROM chats LEFT JOIN users ON user_id = '$incoming_id'WHERE (incoming_id = '$incoming_id' AND outgoing_id = '$outgoing_id') OR (incoming_id = '$outgoing_id' AND outgoing_id = '$incoming_id') ORDER BY msg_id ASC";

        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){

                $color = "#fff";
                if($status == "online"){
                   $icon = "fa-solid fa-check-double"; 
                }else{
                    $icon = "fa-solid fa-check";
                }
                
                if($row['read_status'] == 1)
                {
                    $color = "#0f0";
                    $icon = "fa-solid fa-check-double";
                }

                $time = explode(" ",$row['time'])[1];
                if($row['outgoing_id'] == $outgoing_id){
                    
                    if($row['img'] == NULL)
                    {
                        $message = '<p style="color:'.$chat_setting['OTC'].';font-family:'.$chat_setting['font'].';">'.$row['message'].'</p>';
                    }else if($row['img'] != NULL && $row['message'] != "") {
                        $message = '
                        <a href="fullscreen.php?id='.$row['msg_id'].'&section=chat">
                           <img style="max-width:300px;width:100%; !important;object-fit:cover;padding:0.5rem;margin-right:auto; " src="./includes/'.$row['img'].'">
                            <p style="'.$chat_setting['OTC'].';font-family:'.$chat_setting['font'].';font-size:1.2rem">'.$row['message'].'</p>
                        </a>';
                    }else if($row['img'] != NULL && $row['message'] == "")
                    {
                        $message = '
                        <a href="fullscreen.php?id='.$row['msg_id'].'&section=chat">
                           <img style="max-width:300px;width:100%; !important;object-fit:cover;padding:0.5rem;margin-right:auto; " src="./includes/'.$row['img'].'">
                        </a>';
                    }
                    $output .= 
                    '
                        <div class="outgoing" data-long-press-delay="300" style="background:'.$chat_setting['OB'].'" ondblclick="console.log(this)">
                            '.$message.'
                            <div style="display:flex;justify-content:space-between;padding:0px 5px;">
                                <i style="float:left;color:'.$color.'" class="'.$icon.'"></i>
                                <div class="time" style="text-align:right;color:#00f;font-size:.6rem">'.$time.'</div>
                            </div>
                            
                        </div>
                    ';
                }else if($row['incoming_id'] == $outgoing_id){
                    if($row['img'] == NULL)
                    {
                        $message = '<p style="color:'.$chat_setting['ITC'].';font-family:'.$chat_setting['font'].';">'.$row['message'].'</p>';
                    }else if($row['img'] != NULL && $row['message'] != "") {
                        $message = '
                        <a href="fullscreen.php?id='.$row['msg_id'].'&section=chat">
                            <img style="max-width:250px;width:100%; !important; object-fit:cover; background:#000;padding:0.5rem;margin-right:auto; " src="./includes/'.$row['img'].'">
                            <p style="color:'.$chat_setting['ITC'].';font-family:'.$chat_setting['font'].';font-size:1.2rem">'.$row['message'].'</p>
                        </a>';
                    }else if($row['img'] != NULL && $row['message'] == "")
                    {
                        $message = '
                        <a href="fullscreen.php?id='.$row['msg_id'].'&section=chat">
                            <img style="max-width:250px;width:100%; !important; object-fit:cover; background:#000;padding:0.5rem;margin-right:auto; " src="./includes/'.$row['img'].'">
                        </a>';
                    }

                    $output .=
                    '
                        <div class="incoming" data-long-press-delay="300" onclick="console.log(this)">
                            <div class="profile-pic">
                                <img src="./includes/'.$row['profile_pic'] .'" alt="">
                            </div>
                            <div class="message" style="background:'.$chat_setting['IB'].'">
                                '.$message.'
                                <p class="time" style="text-align:left;color:#00f;font-size:.6rem">'.$time.'</p>
                            </div>
                            
                        </div>
                    ';
                }
            }
            
        }else{
            $output = 
            '
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;text-align:center">
                    <p style="font-size:3rem;text-align:center;color:#000;font-weight:1000;opacity:0.5;font-family:cursive">No chats available. Start Buzzing!!😁</p>
                </div>
            ';
        }
        echo $output;
    }
    
    // var_dump($incoming_id);
    // var_dump($outgoing_id);
    
    