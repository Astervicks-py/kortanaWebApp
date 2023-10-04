<?php
session_start();
require_once "config.php";
require_once "classes.php";

/** Declaration */
$DB = new DB();
$generate = new Generate();
$user = new User();
$user_id = $_SESSION['id'];
$photoName = $_FILES['cover-photo']['name'];
$photoTmp = $_FILES['cover-photo']['tmp_name'];
// $value = $_FILES['cover-photo']['name'];

var_dump($_FILES['cover-photo']);

/** Functions  */

function verify($fileName){
    $extension = array('image/jpg','image/png','image/jpeg');
    if(in_array(strtolower($fileName),$extension)){
        return true;
    }else{
        return false;
    }
}

function download($fileName,$temp,$id){
    /** Create randomized name for each pic */
    $DB = new DB();
    $generate = new Generate();
    $rand = $generate->random(11,"mixed");
    $name = $fileName;
    $filePath = "cover-photos/".$rand."_".$name;

    /** Move The uploaded Folder to the coverphoto folder */
    move_uploaded_file($temp,$filePath);

    /** Add the new file path to the database */
    $sql = "UPDATE users SET cover_photo = '$filePath' WHERE user_id = '$id'";
    return $DB->save($sql);
}

$result = $user->user_data($user_id);

if($result){
    $row = $result[0];

    if($row['cover_photo'] == "/cover-photos/header.jpg"){
        /** Verify Image type */
        if(verify($_FILES['cover-photo']['type'])){

            /** Create Folder for Cover-photo */
            if(!is_dir("cover-photos")){
                mkdir("cover-photos");
            }

            if(download($photoName,$photoTmp,$user_id)){
                echo " Inserted";
            }else{
                echo " Error";
            }
        }
    }
    else{
        /**Get exsiting Cover Photo name */
        if(verify($_FILES['cover-photo']['type'])){

            $result = $user->user_data($user_id);
            if($result){
                $row = $result[0];
                $existing_profile = $row['cover_photo'];
                $exploded = explode("/",$existing_profile);
                $expImg = $exploded[1];

                /** Delete Existing Image */
                if(!unlink("cover-photos/".$expImg)){
                    echo "Cannot be Deleted";
                }else{

                    /** Replace The deleted Image */
                    if(download($photoName,$photoTmp,$user_id,$conn)){
                        echo " Updated";
                    }else{
                        echo " Error";
                    }
                }
            }
        }
    }
}




/** Verify Image type */
// $extension = array('image/jpg','image/png','image/jpeg');
// if(in_array(strtolower($_FILES['cover-photo']['type']),$extension)){

//     /**Get exsiting Profile pic name */
//     $sql = "SELECT * FROM users WHERE user_id = $user_id";
//     if($result = mysqli_query($conn,$sql)){
//         $row = mysqli_fetch_assoc($result);
//         $existing_profile = $row['profile_pic'];
//         $exploded = explode("/",$existing_profile);
//         $expImg = $exploded[1];

//         /** Delete Existing Image */
//         if(!unlink("users-profile/".$expImg)){
//             echo "Cannot be Deleted";
//         }else{

//             /** Replace The deleted Image */
//             $rand = rand();
//             $imageName = $_FILES['profile']['name'];
//             $imagePath = "users-profile/".$rand."_".$imageName;
//             move_uploaded_file($_FILES['profile']['tmp_name'],$imagePath);
//             $sql = "UPDATE users SET profile_pic = '{$imagePath}' WHERE users.user_id = {$user_id}";
//             if(mysqli_query($conn,$sql)){
//                 echo "Updated";
//             }
//         }

        
//     }

    
// }