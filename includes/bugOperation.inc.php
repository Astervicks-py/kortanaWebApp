<?php

session_start();
require "./classes.php";
$DB = new DB();
$id= $_POST['id'];
$error = "";

if($_POST['type'] == "delete")
{
    $error = "DELETE";
    $sql = "DELETE FROM bug_report WHERE id = '$id'";
}else if ($_POST['type'] == "fix")
{
    $error = "FIX";
    $sql = "UPDATE bug_report SET fixed = '1' WHERE id = '$id'";
}

if($DB->save($sql))
{
    echo "SUCCESS";
}else{
    echo "COULDN'T PROCESS " .$error;
}


?>