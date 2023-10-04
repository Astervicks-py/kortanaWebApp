<?php
    require_once "config.php";
    session_start();
    $user_id = $_SESSION['id'];
    $getName = "SELECT username FROM users WHERE user_id = '$user_id'";

    if($result = mysqli_query($conn,$getName)){
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['username'];

        $sql = "DROP TABLE `{$user_name}`";

        if(mysqli_query($conn,$sql)){
            echo "success";
        };
    }

    
?>