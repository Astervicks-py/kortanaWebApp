<?php


// print_r($members);
// die();
// print_r($_POST);
// die();
// print_r($_SESSION);
// print_r($members);
// die();

session_start();
include_once "./classes.php";
$DB = new DB();
$generate = new Generate();
$formData = $_POST;
$error = "";
$admin_id = $_SESSION['id'];
$members = explode(",",$formData['added_comrades']);
array_push($members,$admin_id);
$group_name = addslashes($formData['group_name']);
$group_slogan = addslashes($formData['about_group']);
$group_id = $generate->random(50,"mixed");
$restriction = $_POST['restriction'];
if($restriction == "true")
{
    $restriction = 1;
}else{
    $restriction = 0;
}

if($_FILES['image']['name'] == "")
{
    $imagePath = NULL;
}

/** Check if the group name is empty */
if(!empty($group_name))
{
    /** Check if at least 2 users are added */
    if(count($members)>= 3)
    {
        /** Check if a group dp is added */
        if($_FILES['image']['name'] != "")
        {
            /**Check the file type of the image */
            $extension = array('image/jpg','image/png','image/jpeg');
            if(in_array(strtolower($_FILES['image']['type']),$extension)){
                /** Create Save Image in a images folder and save downloaded images */
                if(!is_dir("group_dp")){
                    mkdir('group_dp');
                }

                $rand =  $generate->random(15,"mixed");
                $imageName = $_FILES['image']['name'];
                $imagePath = "group_dp/".$rand."_".$imageName;
                move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);


            }else{
                $error = "Image must be in .JPEG, .JPG or .PNG format";
            }
        }

       
        

    }else
    {
        $error = "Groups must have atleast 3 members";
    }
}else
{
    $error = "Group Name cannot be empty";
}

if($error == "")
{
    $members = json_encode($members);
    $sql = "INSERT INTO groups (group_id,group_name,admin_id,slogan,group_dp,restricted,members) 
            VALUES ('$group_id','$group_name','$admin_id','$group_slogan','$imagePath','$restriction','$members')";

    if($DB->save($sql))
    {
        echo "Successful";
    }else{
        echo "Something went wrong";
    }
}else{
    echo $error;
}