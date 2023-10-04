<?php

session_start();
require_once "includes/classes.php";
$DB = new DB();
$user_id = $_SESSION['id'];
$FRIENDS = new Friends();
$user_data = new User();
$following = $FRIENDS->get_friends($user_id,"following");
$output = "";
$newArray =[];
$names = ['andy','Michelle','Bryan'];
$Key = array_search("andy",$names);
unset($names[$Key]);

foreach ($names as $newName) {
    $newArray[] = $newName;
}

$converted = json_encode($newArray);
$reconverted = json_decode($converted,true);
// echo $reconverted[1];
echo "<pre>";
var_dump($reconverted);
echo "</pre>";
// echo "<pre>";
// var_dump($following);
// echo "</pre>";
// die();
// UPDATE `users` SET `following` = 0 WHERE 1;
// UPDATE `users` SET `followers` = 0 WHERE 1;
// TRUNCATE TABLE `notifications`;
// UPDATE `users` SET `following_ids` = '' WHERE 1;
// UPDATE `users` SET `followers_ids` = '' WHERE 1;