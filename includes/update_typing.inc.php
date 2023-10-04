<?php
    session_start();
    require_once "classes.php";
    $DB = new DB();
    $user_id = $_SESSION['id'];
    $friend_id = $_POST['friend_id'];

    $sql = "UPDATE chats SET typing = 'typing...' WHERE (incoming_id = '$user_id' && outgoing_id = '$friend_id') || (incoming_id = '$friend_id' && outgoing_id = '$user_id')";
    $result = $DB->save($sql);
    if($result)
    {
       echo "Updated";
    }