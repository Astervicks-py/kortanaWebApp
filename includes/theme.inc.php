<?php

session_start();
require_once "classes.php";
$DB = new DB();
$theme = $_POST['theme'];
$user_id = $_SESSION['id'];
$sql = "UPDATE `users` SET `theme` = '$theme' WHERE `user_id` = '$user_id' ";
if($DB->save($sql))
{
    echo "updated";
}
