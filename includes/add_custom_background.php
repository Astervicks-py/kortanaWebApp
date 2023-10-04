<?php
session_start();
require_once "classes.php";
$DB = new DB();
$user_id = $_SESSION['id'];
$story = new Story();
$generate = new Generate();
$image = $_FILES['custom-background'];
// var_dump($image);
if($story->verify_image($image))
{
    if(!is_dir('custom_background'))
    {
        mkdir('custom_background');
    }
    $rand = $generate->random(11);
    $file_path = 'custom_background/'. $rand . "_" . $image['name'];
    /** Downloading Photo into Local Storage */
    move_uploaded_file($_FILES['custom-background']['tmp_name'],$file_path);
    $sql = "INSERT INTO custom_background(user_id,background) VALUES('$user_id','$file_path')";
    if($DB->save($sql))
    {
        echo true;
    }
}
