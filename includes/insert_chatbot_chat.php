<?php
    require_once "config.php";
    session_start();
    $user_id = $_SESSION['id'];
    $message = strtolower(mysqli_real_escape_string($conn,$_POST['message']));
    $response = '';
    $output = '';
    /** Get Response Fron Kortney */
    if($message !== ''){
        $sql = "SELECT * FROM conversation WHERE question LIKE '%{$message}%' LIMIT 1";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)){
            $row = mysqli_fetch_assoc($result);
            $response = $row['response'];
        }else{
            $response =  "I don't Understand You";
        }

        /** Insert the chat into the newly created table */
        $getName = "SELECT username FROM users WHERE user_id = '{$user_id}'";

        if($result = mysqli_query($conn,$getName)){
            $row = mysqli_fetch_assoc($result);
            echo $row['username'];
            $user_name = $row['username'];

            $sql = "INSERT INTO `{$user_name}` (user_id,message,response) VALUE(?,?,?)";

            /** Start Prepared Statement */
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt,$sql)){
                mysqli_stmt_bind_param($stmt,"sss",$user_id,$message,$response);
                mysqli_stmt_execute($stmt);
                
            }
        }
    }
    
    
?>