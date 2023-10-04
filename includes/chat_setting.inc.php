<?php

require_once "./classes.php";
session_start();
$user_id = $_SESSION['id'];
$DB = new DB();

$ITC = $_POST['ITC'];
$OTC = $_POST['OTC'];
$OBC = $_POST['OBC'];
$IBC = $_POST['IBC'];
$background = $_POST['background_image_value'];
$font = $_POST['font_value'];

$sql = "UPDATE chat_setting SET ITC ='$ITC' ,OTC = '$OTC',IB = '$IBC',OB = '$OBC',font = '$font',background = '$background' WHERE user_id = '$user_id' ";

    // echo $sql;
    // die();
if($DB->save($sql))
{
    echo "updated";
}else{
    echo "Something went wrong";
}

