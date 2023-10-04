<?php
    session_start();
    require_once "config.php";
    include_once "classes.php";

    $caption = mysqli_real_escape_string($conn,$_POST['caption']);
    $imagePath = "";
    $likes =1;
    $user_id = $_SESSION['id'];
    $DB = new DB();
    $notify = new Notify();
    $generate = new Generate();

    /** Test */
    
    // var_dump($result);
    // die();
    
    /** Check if all input are empty */
    if($_FILES['image']['name'] !="" || !empty($caption)){

        /** If Image is uploaded and Checking extension of image */
        if($_FILES['image']['name'] !=""){
            $extension = array('image/jpg','image/png','image/jpeg');
            if(in_array(strtolower($_FILES['image']['type']),$extension)){
               
                /** Creating Photo Path */
                $imgName = $_FILES['image']['name'];
                $rand = time();
                $imagePath = "posts/".$rand."_".$imgName;

                if(!is_dir('posts')){
                    mkdir('posts');
                }

                /** Downloading Photo into Local Storage */
                move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
                
            }else{
                echo "Profile Picture must be - jpeg jpg or png.";
                die();
            }
        }else{
            $imagePath = NULL;
        }

        /** Generate POST_ID */
        $post_id =  $generate->random(11,"mixed");
        /** Insert Post into the database */
        $sql = "INSERT INTO post(post_id,user_id,img,caption,likes) VALUES(?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"sssss",$post_id,$user_id,$imagePath,$caption,$likes);
            if(mysqli_execute($stmt)){

                /** Notify Friends */
                $type = "post";
                $sql = "SELECT post_id FROM post WHERE user_id = '$user_id' ORDER BY post_id DESC LIMIT 1";
                $post_id = $DB->read($sql)[0]['post_id'];
                $result3 = $notify->insert_post_notification($user_id,$type,$post_id);
                echo "Posted";
            }else{
                echo "Something went wrong! Refresh and try again";
                die();
            }
        }else{
            echo "Something went wrong! Refresh and try again";
            die();
        }
    }else{
        echo "No Inputs were made.";
        die();
    }

    
