<?php 

require_once "classes.php";
$notify = new Notify();
$DB = new DB();
session_start();
$user_id = $_SESSION['id'];
$friend_id = $_POST['incoming_id'];

// print_r($user_id);
// echo "<pre>";
// print_r($friend_id);

// $sql = "SELECT * FROM chats WHERE (incoming_id = '$incoming_id' AND outgoing_id = '$outgoing_id') OR (incoming_id = '$outgoing_id' AND outgoing_id = '$incoming_id') ORDER BY msg_id ASC";

$sql = "UPDATE chats SET read_status = 1 WHERE (incoming_id = '$user_id' AND outgoing_id = '$friend_id')";
$DB->save($sql);
?>