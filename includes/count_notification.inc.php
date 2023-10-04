<?php 


require_once "classes.php";
session_start();
$user_id = $_SESSION['id'];
$DB = new DB();
$notify = new Notify();

$notification = $notify->get_notific($user_id);
$unread = [];
if(is_array($notification))
{
    foreach ($notification as $notific) {
        if($notific['status'] == 0)
        {
            $unread[] = $notific;
        }
    }
}

$notification_count = count($unread);
echo $notification_count;
?>