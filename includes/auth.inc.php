<?php

    include "./classes.php";
    session_start();
    $DB = new DB();
    $user_id = $_SESSION['id'];
    $localStorage = $_POST['localStoragePin'];
    $pin = $_POST['pin'];
    $password = $_POST['password'];

    $sql = "SELECT token FROM users WHERE user_id = '$user_id'";
    $token = $DB->read($sql)[0]['token'];
    $message = "";

    if(empty($pin) || empty($password))
    {
        $message = "One or more columns are unfilled!";
    }else{
        if($pin != $token || $password != $localStorage)
        {
            $message = "Invalid/Expired Pin/Password";
        }else{
            $sql = "UPDATE users SET is_open = 'true' WHERE user_id = '$user_id'";
            $DB->save($sql);
            $message = "MATCHED";
        }
    }

    echo $message;
?>