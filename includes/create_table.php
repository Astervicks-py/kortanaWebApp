<?php
    require_once "config.php";
    session_start();
    $user_id = $_SESSION['id'];
    $getName = "SELECT username FROM users WHERE user_id = '$user_id'";

    if($result = mysqli_query($conn,$getName)){
        $row = mysqli_fetch_assoc( $result);
        $user_name = $row['username'];
        $sql = "CREATE TABLE `{$user_name}` (
            chat_id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
            user_id INT(11) NOT NULL,
            message VARCHAR(255) NOT NULL,
            response VARCHAR(2000) NOT NULL
        )";

        if(mysqli_query($conn,$sql)){
            echo "success";
        };
    }

    
    

?>