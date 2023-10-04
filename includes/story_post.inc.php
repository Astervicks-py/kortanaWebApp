<?php
session_start();
require_once "classes.php";
$DB = new DB();
$generate = new Generate();
$story = new Story();
$user_id = $_SESSION['id'];
$post_id = $generate->random(11);

if(!isset($_FILES['image']) || $_FILES['image']['name'] == "")
{
    $text_color = $_POST['color'];
    $background = $_POST['background'];
    $font = $_POST['font'];
    $caption = mysqli_real_escape_string($DB->connect(),$_POST['caption']);
    $sql = "INSERT INTO `stories` (user_id,post_id,caption,background,text_color,font) VALUES('$user_id','$post_id','$caption','$background','$text_color','$font')";
    if($DB->save($sql))
    {
        echo "Posted";
    }else{
        echo "Something Went Wrong";
    }
}else{
    $image = $_FILES['image'];
    if($story->verify_image($image))
    {
        if(!is_dir("stories"))
        {
            mkdir("stories");
        }

        $file_path = "stories/" . $generate->random(11) . "_" . $image['name'];
        move_uploaded_file($image['tmp_name'],$file_path);
        $caption = addslashes(htmlspecialchars($_POST['img_caption']));
        $sql = "INSERT INTO `stories` (user_id,post_id,caption,img) VALUES('$user_id','$post_id','$caption','$file_path')";
        if($DB->save($sql))
        {
            echo "Posted";
        }else{
            echo "Something Went Wrong";
        }
    }else{
        echo "Media format must be Jpeg, png or Jpg";
    }
    
}


?>