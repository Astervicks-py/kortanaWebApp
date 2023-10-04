<?php
require_once "config.php";
session_start();
$user_id = $_SESSION['id'];
$newUsername = mysqli_real_escape_string($conn,$_POST['username']);
$fname = ucfirst(mysqli_real_escape_string($conn,$_POST['fname']));
$lname = ucfirst(mysqli_real_escape_string($conn,$_POST['lname']));
$location = mysqli_real_escape_string($conn,$_POST['location']);
$newBio = mysqli_real_escape_string($conn,$_POST['bio']);
$newQuestion = mysqli_real_escape_string($conn,$_POST['recovery_question']);
$newAnswer = mysqli_real_escape_string($conn,$_POST['recovery_answer']);

/** Insert The new Details */


$sql = "UPDATE users SET 
        username = '{$newUsername}', 
        bio = '{$newBio}', 
        recovery_question = '$newQuestion',
        location = '$location' ,
        fname = '$fname' ,
        lname = '$lname',
        recovery_answer = '$newAnswer'
    WHERE user_id = '$user_id'";
if(mysqli_query($conn,$sql)){
    echo "updated";
}else{
    // $error = 'Update Unsuccessful Please Make sure you have enter the right info';
    echo "ERROR OCCURED";
}
