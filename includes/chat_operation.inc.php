<?php

session_start();
include_once "./config.php";
include_once "./classes.php";
$DB = new DB();
$notify = new Notify();

// echo 'connected';
$operation = mysqli_real_escape_string($conn,$_POST['operation']);
$user_id = mysqli_real_escape_string($conn,$_SESSION['id']);

if($operation == "block")
{
    
    $incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
    $sql = "SELECT blocked FROM users WHERE user_id = '$user_id'";
    $result = $DB->read($sql)[0]['blocked'];
    if(!is_null($result))
    {
        $blocked = json_decode($result,true);   
    }
    $blocked[] = $incoming_id;
    $blocked = json_encode($blocked);
    
    $sql = "UPDATE users SET blocked = '$blocked' WHERE user_id = '$user_id'";
    if($DB->save($sql))
    {
        $notify->insert_Follow_notification($incoming_id,$user_id,"blocked");
        echo "Operation successful";
    }


}

elseif ($operation == "unfollow" || $operation == "report") {
    
    $incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
    if($operation == "report")
    {
        $sql = "INSERT INTO reports 
        (defaulter_id,reporter_id) VALUES('$incoming_id','$user_id')";
        $DB->save($sql);
    }
    
    /**
     * Remove my id from the followers of the users
     */

    $sql = "SELECT * FROM followers WHERE user_id = '$incoming_id'";
    $result = $DB->read($sql);
    if(is_array($result))
    {
        $followers = json_decode($result[0]['followers'],true);
        $followers_ids = array_column($followers,"user_id");

        /** If my id is in follower's id remove it!! */
        if(in_array($user_id,$followers_ids))
        {
            /** unfollow */
            $key = array_search($user_id,$followers_ids);
            unset($followers[$key]);

            /** Update database */
            $follow_string = json_encode($followers);
            $sql = "UPDATE followers SET followers = '$follow_string' WHERE user_id = '$incoming_id'";
            if($DB->save($sql))
            {
                
                
                $sql = "UPDATE users SET followers = followers - 1 WHERE user_id = '$incoming_id'";
                if($DB->save($sql))
                {
                    
                    /** Notify Friend */
                    
                    $type = "unfollow";
                    $notify->insert_Follow_notification($incoming_id,$user_id,$type);
                    
                    
                    /** Adjust following Table */
                    $sql = "SELECT * FROM following WHERE user_id = '$user_id'";
                    if($following_data = $DB->read($sql))
                    {
                        if(is_array($following_data))
                        {
                            $following = json_decode($following_data[0]['following'],true);
                            $following_ids = array_column($following,"user_id");
                            if(in_array($incomming_id,$following_ids))
                            {
                                /** unfollow */
                                $key = array_search($incoming_id,$following_ids);
                                unset($following[$key]);
                                
                                
                                $follow_string = json_encode($following);

                                $sql = "UPDATE following SET following = '$follow_string' WHERE user_id = '$user_id'";
                                if($DB->save($sql))
                                {
                                    $sql = "UPDATE users SET following = following - 1 WHERE user_id = '$user_id'";
                                    if($DB->save($sql))
                                    {
                                        echo "Operation successful";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

elseif ($operation == "unblock") {
    
    $incoming_id = mysqli_real_escape_string($conn,$_POST['incoming_id']);
    $sql = "SELECT blocked FROM users WHERE user_id = '$user_id'";
    if($DB->read($sql))
    {
        $result = $DB->read($sql)[0]['blocked'];
        if(!is_null($result))
        {
            $blocked_users = json_decode($result,true);
            if(is_array($blocked_users))
            {
                
                $index = array_keys($blocked_users,$incoming_id);
                if($index)
                {
                    unset($blocked_users[$index[0]]);
                    $blocked_users_string = json_encode($blocked_users);
                    $sql = "UPDATE users SET blocked = '$blocked_users_string' WHERE user_id = '$user_id'";
                    if($DB->save($sql))
                    {
                        $notify->insert_Follow_notification($incoming_id,$user_id,"unblocked");
                        echo "Operation successful";
                    }
                }else{
                    echo "Not found";
                }
            }
        }
    }
}

elseif ($operation == "edit_slogan") {
    $group_id = $_POST['group_id'];
    $new_slogan = addslashes($_POST['slogan_edit']);
    $sql = "UPDATE groups SET slogan = '$new_slogan' WHERE group_id = '$group_id'";
    if($DB->save($sql))
    {
        $notify->insert_slogan_change_notification($group_id,"slogan");
        echo "Operation successful";
    }
}