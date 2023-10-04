<?php

require_once "classes.php";
$DB = new DB();
$story = new Story();
$image = $_FILES['image'];
if($story->verify_image($image))
{
    if(!is_dir("stories"))
    {
        mkdir("stories");
    }
    $file_path = "stories/" . $image['name'];
    move_uploaded_file($image["tmp_name"],$file_path);
    echo $file_path;
}