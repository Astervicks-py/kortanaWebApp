<?php

session_start();
include "./classes.php";
include "./config.php";
$DB = new DB();
$user_id = $_SESSION['id'];
$count = 0;
$read_receipt = [];
$groups_belonged = [];


$sql = "SELECT * FROM groups";
$groups = $DB->read($sql);
foreach ($groups as $group) {
    $members = json_decode($group['members'],true);
    if(in_array($user_id,$members))
    {
        $groups_belonged[] = $group['group_id'];
    }
}
// echo "<pre>";
// print_r($groups_belonged);
// // echo $count;
// echo "</pre>";

if(count($groups_belonged) > 0)
{
    foreach ($groups_belonged as $group) {
        $sql = "SELECT * FROM group_chat WHERE incoming_id = '$group'";
        $chats = $DB->read($sql);
        if(is_array($chats))
        {
            if(count($chats) > 0)
            {
                foreach ($chats as $read) {
                    $read_receipt[] =  json_decode($read['read'],true);
                }
            }
        }
        
    }
}





foreach ($read_receipt as $key) {
    if(is_array($key))
    {
        if(!in_array($user_id,$key))
        {
            $count++;
        }
    }
    
}
// echo "<pre>";
// print_r($read_receipt);
echo $count;
// echo "</pre>";

?>