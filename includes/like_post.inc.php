<?php

    include_once "classes.php";
    
    session_start();
    $DB = new DB();
    $notify = new Notify();
    $user_id = $_SESSION['id'];
    $link = $_POST['link'];
    echo $link;
    // http://localhost/Kortana/like.php?id=oIE4xR5EJb1
    $post_id = explode("=",explode("?",$link)[1])[1];
    // var_dump($post_id);
    // die();
    $sql = "SELECT * FROM post WHERE post_id = '$post_id' LIMIT 1";
    $row = $DB->read($sql)[0];
    $friend_id = $row['user_id'];


    $sql = "SELECT likes FROM likes WHERE post_id = '$post_id' LIMIT 1";
    $result = $DB->read($sql);
    // var_dump($result);
    // die();
    if(is_array($result))    
    {
        /** Convert the retrived likes back to array */
        $likes = json_decode($result[0]['likes'],true);
        /** Check if the user have liked */
        $user_ids = array_column($likes,"user_id");

        if(!in_array($user_id,$user_ids))
        {
            $arr["user_id"] = $user_id;
            $arr["date"] = date("Y-m-d H:i:s");

            /** Add the new info to the end of the existing likes data */
            $likes[] = $arr;
            $like_string = json_encode($likes);
            $query = "UPDATE likes SET likes = '$like_string' WHERE post_id = '$post_id'";
            if($DB->save($query))
            {
                /** Update the posts like column in post */
                $query2 = "UPDATE post SET likes = likes + 1 WHERE post_id = '$post_id'";
                if($DB->save($query2))
                {
                    
                    /** Notify Friend */
                    
                    $type = "like";
                    $result = $notify->insert_like_notification($friend_id,$user_id,$type,$post_id);
                    echo "Liked";
                }
            }

            
        }else{
            
            /** Unlike Post */
            $key = array_search($user_id,$user_ids);
            unset($likes[$key]);

            $likes_string = json_encode($likes);
            $sql = "UPDATE likes SET likes = '$likes_string' WHERE post_id = '$post_id'";
            if($DB->save($sql))
            {
                 /** Decrement Posts likes */
                $sql = "UPDATE post SET likes = likes - 1 WHERE post_id = '$post_id' LIMIT 1";
                if($DB->save($sql))
                {
                    /** Notify Friend */
                    
                    $type = "unlike";
                    $result = $notify->insert_like_notification($friend_id,$user_id,$type,$post_id);

                    echo " You have unliked";
                }
                
            }
        }
    }else
    {
        $arr["user_id"] = $user_id;
        $arr["date"] = date("Y-m-d H:i:s");

        $arr2[] = $arr;
        /** Convert into a string */
        $likes = json_encode($arr2);
        $query = "INSERT INTO likes(post_id,likes) VALUES('$post_id','$likes')";
        $DB->save($query);

        /** Update the posts like column in post */
        $query2 = "UPDATE post SET likes = likes + 1 WHERE post_id = '$post_id'";
        if($DB->save($query2))
        {
            /** NOTIFY FRIEND */
            $type = "like";
            $result = $notify->insert_like_notification($friend_id,$user_id,$type,$post_id);
            echo "Liked";
        }
        
    }
?>