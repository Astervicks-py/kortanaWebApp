<?php

session_start();
require_once "classes.php";
$DB = new DB();
$post = new Post();

$initial_id = addslashes(mysqli_real_escape_string($DB->connect(),$_POST['initial_id']));
$post_id = addslashes(mysqli_real_escape_string($DB->connect(),$_POST['post_id']));
$caption = addslashes(mysqli_real_escape_string($DB->connect(),$_POST['share-caption']));
$user_id = $_SESSION['id'];

$result = $post->repost($initial_id,$user_id,$caption,$post_id);
if($result)
{
    echo true;
}else{
    echo false;
}


?>