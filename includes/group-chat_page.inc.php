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
    // echo "Conected successfully";
    $my_id = mysqli_real_escape_string($conn,$_POST['outgoing_id']);
    $chat_with_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
    $message = $_POST['message'];
    $image = $_FILES['image'];
    if(!empty($message) || !$image['name'] == ""){

        if($_FILES['image']['name'] != "")
        {
            
            $image = $_FILES['image'];
            $tmpName = $image['tmp_name'];
            $extension = array('image/jpg','image/png','image/jpeg');
            if(in_array(strtolower($image['type']),$extension)){
                if(!is_dir("group-chat_images"))
                {
                    mkdir("group-chat_images");
                }
                $newName = "group-chat_images/" . "_" . $generate->random(11). "_" . $image['name'];
                move_uploaded_file($tmpName,$newName);
                $imagePath = $newName;
            }
        }

        $people_that_read[] = $my_id;
        $new_read = json_encode($people_that_read);

        $message_id = $generate->random(50,'mixed');

        /** Updating the order */
        $members;
        $sql = "SELECT members FROM groups WHERE group_id = '$chat_with_id'";
        if($result = $DB->read($sql))
        {
            
            $result = $result[0]['members'];
            if(!is_null($result))
            {
                $members = json_decode($result);
            }
        }
        if($chat->userGroup_update_history($members,$chat_with_id))
        {
            $sql3 = "INSERT INTO group_chat(incoming_id,outgoing_id,message,message_id,img) VALUES(?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt,$sql3)){

                mysqli_stmt_bind_param($stmt,"sssss",$chat_with_id,$my_id,$message,$message_id,$imagePath);
                if(mysqli_stmt_execute($stmt)){
                    
                    $people_that_read[] = $my_id;
                    $new_read = json_encode($people_that_read);

                    
                    $sql = "UPDATE group_chat SET `read` = '$new_read' WHERE message_id = '$message_id'";
                    if($DB->save($sql))
                    {

                        
                        echo "Inserted";
                    }
                    
                }
            }
        }
        
    }
    

?>