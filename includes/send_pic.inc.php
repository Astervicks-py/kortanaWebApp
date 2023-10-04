<?php

session_start();
require_once "config.php";
echo "Conected successfully";
$outgoing_id = mysqli_real_escape_string($conn,$_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
$img = $_FILES['img']['tmp_name'];
$status = "unread";
// var_dump($outgoing_id);
// var_dump($incoming_id);
// var_dump($message);

if(empty($message)){
    $extension = array('image/jpg','image/png','image/jpeg');
    if(in_array(strtolower($_FILES['img']['type']),$extension)){
        if(!is_dir('chat_images')){
            mkdir('chat_images');
        }
        $rand = time();
        $imageName = $_FILES['img']['name'];
        $imagePath = "chat_images/".$rand.'_'.$imageName;
        
        move_uploaded_file($img,$imagePath);
        $sql = "INSERT INTO chats(img,incoming_id,outgoing_id) VALUES(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"sss",$imagePath,$incoming_id,$outgoing_id);
            if(mysqli_stmt_execute($stmt)){
                echo "Inserted";
            }
        }
    }
}else{
    header('location:./chat_page.php');
    die();
}