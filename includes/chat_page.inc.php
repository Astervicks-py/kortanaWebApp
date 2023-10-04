<?php 

    session_start();
    require_once "config.php";
    require_once "classes.php";
    $DB = new DB();
    $generate = new Generate();
    $chat = new Chat();
    // var_dump($_FILES);
    // die();
    $imagePath = NULL;
    echo "Conected successfully";
    $my_id = mysqli_real_escape_string($conn,$_POST['outgoing_id']);
    $chat_with_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
    $message = $_POST['message'];
    $image = $_FILES['image'];
    if(!empty($message) || !$image['name'] == ""){

        /**
         * Updating the history of logged user and friends 
         */

        $update_user_history = $chat->update_history($my_id,$chat_with_id);

        if($_FILES['image']['name'] != "")
        {
            
            $image = $_FILES['image'];
            $tmpName = $image['tmp_name'];
            $extension = array('image/jpg','image/png','image/jpeg');
            if(in_array(strtolower($image['type']),$extension)){
                if(!is_dir("chat_images"))
                {
                    mkdir("chat_images");
                }
                $newName = "chat_images/" . "_" . $generate->random(11). "_" . $image['name'];
                move_uploaded_file($tmpName,$newName);
                $imagePath = $newName;
            }
        }

        /** Insert Chat */
        if($update_user_history)
        {
            $status = 0;
            $sql3 = "INSERT INTO chats(incoming_id,outgoing_id,message,img,read_status) VALUES(?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt,$sql3)){
                mysqli_stmt_bind_param($stmt,"ssssi",$chat_with_id,$my_id,$message,$imagePath,$status);
                if(mysqli_stmt_execute($stmt)){
                    echo "Inserted";
                }
            }
        }
        
    }
    

?>