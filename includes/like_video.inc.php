<?php

require_once "config.php";
session_start();
$user_id = $_SESSION['id'];

$sql = "SELECT * FROM test WHERE user_id = '$user_id'";
if($result = mysqli_query($conn,$sql))
{
    if(!mysqli_num_rows($result) > 0)
    {
        $sql = "INSERT INTO test (user_id) VALUE('$user_id')";
        if(mysqli_query($conn,$sql))
        {
            echo "Liked";
        }
    }else
    {
        echo "You have liked Before";
    }
}