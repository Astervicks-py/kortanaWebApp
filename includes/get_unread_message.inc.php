<?php 

require_once "classes.php";
$DB = new DB();
session_start();
$user_id = $_SESSION['id'];

$sql = "SELECT * FROM chats WHERE incoming_id = '$user_id'";
$number = 0;
$result = $DB->read($sql);

if($result)
{
    foreach ($result as $row) {
        if($row['read_status'] == 0){
            $number++;
        }
    }
    
}





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

echo $number + $count;
?>