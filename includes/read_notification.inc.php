<?php 

require_once "classes.php";
$notify = new Notify();
session_start();
$user_id = $_SESSION['id'];
$notify->read_notification($user_id);

?>