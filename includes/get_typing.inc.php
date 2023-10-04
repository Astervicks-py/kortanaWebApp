<?php
session_start();
require_once "classes.php";
$DB = new DB();
$user_id = $_SESSION['id'];
$friend_id = $_POST['friend_id'];

$sql = "SELECT typing FROM `chats` WHERE (incoming_id = '$user_id' && outgoing_id = '$friend_id') || (incoming_id = '$friend_id' && outgoing_id = '$user_id') ORDER BY msg_id DESC LIMIT 1";
$result = $DB->read($sql);
if($result)
{
    $row = $result[0];
    echo $row['typing'];
}else{
    echo "";
}
