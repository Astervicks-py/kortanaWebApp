<?php

require_once "config.php";

session_start();
$user_id = $_SESSION['id'];

/** Verify Image type */
$extension = array('image/jpg','image/png','image/jpeg');
if(in_array(strtolower($_FILES['profile']['type']),$extension)){

    /**Get exsiting Profile pic name */
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    if($result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_assoc($result);
        $existing_profile = $row['profile_pic'];
        $exploded = explode("/",$existing_profile);
        $expImg = $exploded[1];

        /** Delete Existing Image */
        if(!unlink("users-profile/".$expImg)){
            echo "Cannot be Deleted";
        }else{

            /** Replace The deleted Image */
            $rand = time();
            $imageName = $_FILES['profile']['name'];
            $imagePath = "users-profile/".$rand."_".$imageName;
            move_uploaded_file($_FILES['profile']['tmp_name'],$imagePath);
            
            $sql = "UPDATE users SET profile_pic = '{$imagePath}' WHERE users.user_id = '$user_id'";
            if(mysqli_query($conn,$sql)){
                echo "Updated";
            }
        }

        
    }

    
}