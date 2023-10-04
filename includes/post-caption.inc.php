<?php

require_once "config.php";
require_once "classes.php";
$generate = new Generate();
$notify = new Notify();
session_start();

$user_id = $_SESSION['id'];
$caption = mysqli_real_escape_string($conn,$_POST['caption']);
$likes = 1;
if(!empty($caption)){
    $post_id = $generate->random(11,"mixed");
    $sql = "INSERT INTO post (user_id,post_id,caption,likes) VALUES(?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"ssss",$user_id,$post_id,$caption,$likes);
        mysqli_stmt_execute($stmt);

        $type = "post";
        $result3 = $notify->insert_post_notification($user_id,$type,$post_id);
        echo "caption Posted";
    }
}else{
    echo "Empty Slot";
}

