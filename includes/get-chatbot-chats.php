<?php
    require_once "config.php";
    session_start();
    $user_id = $_SESSION['id'];
    $output = '';
    /** Get Response Fron Kortney */
    $getName = "SELECT username FROM users WHERE user_id = '$user_id'";

    if($result = mysqli_query($conn,$getName)){
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['username'];
        
        $sql = "SELECT * FROM `{$user_name}` ORDER BY chat_id ASC";
        if($result = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_assoc($result)){
                $output .= '
                
                    <div class="outgoing">
                        <p>'.$row['message'].'</p>
                    </div>
                    
                    <div class="incoming">
                        <div class="profile-pic">
                            <img src="./Kortana_chatbot.png" alt="">
                        </div>
                        <p>'.$row['response'].'</p>
                    </div>
                ';
            }
            echo $output;
        }
    }
?>