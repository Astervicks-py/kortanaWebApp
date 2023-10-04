<?php

require_once "config.php";
session_start();
$user_id = $_SESSION['id'];
$feedback = mysqli_real_escape_string($conn,$_POST['feedback']);

$stmt = mysqli_stmt_init($conn);
$sql = "INSERT INTO feedback (user_id,feedback) VALUE(?,?)";
if(mysqli_stmt_prepare($stmt,$sql))
{
    mysqli_stmt_bind_param($stmt,'ss',$user_id,$feedback);
    if(mysqli_stmt_execute($stmt))
    {
        echo "success";
    }
}