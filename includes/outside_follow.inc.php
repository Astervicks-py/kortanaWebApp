<?php
    session_start();
    require_once "classes.php";
    /** Declarations */
    $DB = new DB();
    $notify = new Notify();
    $id = $_SESSION['id'];
    $link =  explode("/",$_POST['link']);
    // var_dump ($link);

    $friend_id = addslashes($link[4]);
    $sql = "SELECT * FROM followers WHERE user_id = '$friend_id'";
    // var_dump($link);
    // die();
    $result = $DB->read($sql);

    if(is_array($result))
    {
        $followers = json_decode($result[0]['followers'],true);
        
        $followers_ids = array_column($followers,"user_id");
        // var_dump($followers_ids);
        if(in_array($id,$followers_ids))
        {
            /** unfollow */
            $key = array_search($id,$followers_ids);
            unset($followers[$key]);

            /** Update database */
            $follow_string = json_encode($followers);
            $sql = "UPDATE followers SET followers = '$follow_string' WHERE user_id = '$friend_id'";
            if($DB->save($sql))
            {
                echo "Followers inserted";
                
                $sql = "UPDATE users SET followers = followers - 1 WHERE user_id = '$friend_id'";
                if($DB->save($sql))
                {
                    echo "success";
                    /** Notify Friend */
                    
                    $type = "unfollow";
                    $notify->insert_Follow_notification($friend_id,$id,$type);
                    
                    
                    /** Adjust following Table */
                    $sql = "SELECT * FROM following WHERE user_id = '$id'";
                    $following_data = $DB->read($sql);
                    if(is_array($following_data))
                    {
                        $following = json_decode($following_data[0]['following'],true);
                        $following_ids = array_column($following,"user_id");

                        // echo "<pre>";
                        // var_dump($following_ids);
                        // var_dump($friend_id);
                        // echo "<pre/>";

                        if(in_array($friend_id,$following_ids))
                        {
                            /** unfollow */
                            $key = array_search($friend_id,$following_ids);
                            unset($following[$key]);
                            
                            echo "Key Unset successful";
                            $follow_string = json_encode($following);

                            $sql = "UPDATE following SET following = '$follow_string' WHERE user_id = '$id'";
                            if($DB->save($sql))
                            {
                                $sql = "UPDATE users SET following = following - 1 WHERE user_id = '$id'";
                                $DB->save($sql);
                            }
                        }
                    }else{
                        echo "Not Array";
                    }
                }
                
            }
        }else
        {
            $arr["user_id"] = $id;
            $arr["date"] = date("Y:m:d H:i:s");

            $followers[] = $arr;
            $follow_string = json_encode($followers);

            $sql = "UPDATE followers SET followers = '$follow_string' WHERE user_id = '$friend_id'";
            if($DB->save($sql))
            {
                echo "Followers inserted";

                $sql = "UPDATE users SET following = following + 1 WHERE user_id = '$id'";
                if( $DB->save($sql))
                {
                    echo "Following Updated";

                    $sql = "UPDATE users SET followers = followers + 1 WHERE user_id = '$friend_id'";
                    if($DB->save($sql))
                    {
                        echo "Followers Updated";
                        echo "follow Successful";

                        /** Notify Friend */

                        $type = "follow";
                        $notify->insert_Follow_notification($friend_id,$id,$type);

                        /** Update following table */
                        $sql = "SELECT * FROM following WHERE user_id = '$id'";
                        $result = $DB->read($sql);
                        $following_arr["user_id"] = $friend_id;
                        $following_arr["date"] = date("Y:m:d H:i:s");

                        if(is_array($result))
                        {
                            $existing_following = json_decode($result[0]['following'],true);
                            $existing_following[] = $following_arr;
                            
                            $follow_string = json_encode($existing_following);

                           

                            $sql = "UPDATE following SET `following` = '$follow_string' WHERE user_id = '$id'";
                            $DB->save($sql);
                        }else{
                            $FOLLOWING_ARR[] = $following_arr;
                            $follow_string = json_encode($FOLLOWING_ARR);                       
                        
                            $sql = "INSERT INTO following(user_id,following) VALUE('$id','$follow_string')";
                            $DB->save($sql);
                        }
                    }
                }
            }
        }
    }else
    {
        $arr["user_id"] = $id;
        $arr["date"] = date("Y:m:d H:i:s");

        $ARR[] = $arr;
        $follow_string = json_encode($ARR);

        $sql = "INSERT INTO followers(user_id,followers) VALUES('$friend_id','$follow_string')";
        if($DB->save($sql))
        {
            echo "Followers inserted";

            $sql = "UPDATE users SET following = following + 1 WHERE user_id = '$id'";
            if($DB->save($sql))
            {
                echo "Following Updated";

                $sql = "UPDATE users SET followers = followers + 1 WHERE user_id = '$friend_id'";
                if($DB->save($sql))
                {
                    echo "Followers Updated";
                    /** Update following table */
                    $sql = "SELECT * FROM following WHERE user_id = '$id'";
                    $result = $DB->read($sql);
                    $following_arr["user_id"] = $friend_id;
                    $following_arr["date"] = date("Y:m:d H:i:s");

                    if(is_array($result))
                    {
                        $existing_following = json_decode($result[0]['following'],true);
                        $existing_following[] = $following_arr;
                        $follow_string = json_encode($existing_following);
                        $sql = "UPDATE following SET following = '$follow_string' WHERE user_id = '$id'";
                        if($DB->save($sql))
                        {
                            header("location:../friends_profile_page.php?id=$friend_id");
                        }
                    }else{
                        $FOLLOWING_ARR[] = $following_arr;
                        $follow_string = json_encode($FOLLOWING_ARR);                       
                    
                        $sql = "INSERT INTO following(user_id,following) VALUE('$id','$follow_string')";
                        $DB->save($sql);
                    }
                    
                }
            }
        }

    }
?>