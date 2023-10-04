<?php 
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$status = "offline";
$is_open = "false";
$sql = "UPDATE users SET status = '{$status}'  WHERE user_id = '{$id}'";
if(mysqli_query($conn,$sql)){
    $sql = $sql = "UPDATE users SET is_open = '{$is_open}'  WHERE user_id = '{$id}'";
    if(mysqli_query($conn,$sql)){
        session_unset();
        // session_destroy();
        header('location:../login.php');
    }
    
}
