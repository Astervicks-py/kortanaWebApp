<?php

require_once "config.php";
session_start();
$user_id = $_SESSION['id'];
$reason = mysqli_real_escape_string($conn,$_POST['reason_for_delete']);
$stmt = mysqli_stmt_init($conn);
$sql = "INSERT into feedback(user_id,feedback) VALUE (?,?)";

if(mysqli_stmt_prepare($stmt,$sql))
{
    mysqli_stmt_bind_param($stmt,'ss',$user_id,$reason);
    mysqli_execute($stmt);
    $sql = "DELETE FROM users WHERE users.user_id = '$user_id'";
    if(mysqli_query($conn,$sql)) 
    {
        echo "success";
    } 
}
