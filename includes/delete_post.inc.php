<?php
    require_once "config.php";
    session_start();
    if(isset($_POST['post_id']))
    {
        $post_id = addslashes($_POST['post_id']);
        $sql = "DELETE FROM comments WHERE post_id = '$post_id'";
        $sql2 = "SELECT * FROM post WHERE post_id = '$post_id'";
        if(mysqli_query($conn,$sql))
        {
            if($result = mysqli_query($conn,$sql2))
            {
                $row = mysqli_fetch_assoc($result);
                if($row['img'] != NULL || $row['img'] != "")
                {
                    /** get Post */
                    $existing_profile = $row['img'];
                    $exploded = explode("/",$existing_profile);
                    $expImg = $exploded[1];
                    // var_dump($exploded);
                    // die();
                    /** Delete Existing Image */
                    if(!unlink("posts/".$expImg)){
                        echo "Not deleted";
                    }
                }
                // echo "Ready for deletion";
                // die();
                $sql = "DELETE FROM post WHERE post_id= '$post_id'";
                if(mysqli_query($conn,$sql)){
                    echo "Deleted";
                } 

                
                
                
                
            }
        }
        
        

    }
?>