<?php
class DB
{
    private $host = "localhost";
    private $username = "astervicks";
    private $password = "astervicks000";
    private $db = "kortana";

    public function connect()
    {
        $conn = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $conn;
    }

    public function read($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn,$query);
        if($result)
        {
            $data = false;
            while($row = mysqli_fetch_assoc($result))
            {
                $data[] = $row;
                
            }
            return $data;
        }else
        {
            return false;
        }
    }

    public function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn,$query);

        if($result)
        {
            return true;
        }else
        {
            return false;
        }
    }
}

class Notify
{

    public function insert_Follow_notification($receiver_id,$about_id,$type)
    {
        $receiver_id = addslashes($receiver_id);
        $about_id = addslashes($about_id);
        $DB = new DB();
        $message = "";
        $sql = "SELECT username,profile_pic FROM users WHERE user_id = '$about_id' ";
        $row = $DB->read($sql)[0];
        $status = 0;
        if ($type == "unfollow") {
            $message = $row['username'] . " unfollowed You 😥😣";
        }

        if ($type == "blocked") {
            $message = $row['username'] . " blocked You 😥😣";
        }

        if ($type == "follow") {
            $message = $row['username'] . " started following You 😊🙈";
        }

        if ($type == "unblocked") {
            $message = $row['username'] . " has unblocked You. Wanna chat up";
        }

        $sql = "INSERT INTO notifications (
                user_id,about_id,message,type,status
            ) 
            VALUES(
                '$receiver_id','$about_id','$message','$type','$status'
        )";

        return $DB->save($sql);
    }

    public function insert_like_notification($receiver_id,$about_id,$type,$post_id)
    {
        $receiver_id = addslashes($receiver_id);
        $about_id = addslashes($about_id);
        $post_id = addslashes($post_id);
        $DB = new DB();
        $message = "";
        $status = 0;
        $sql = "SELECT username,profile_pic FROM users WHERE user_id = '$about_id' ";
        $row = $DB->read($sql)[0];

        if($type == "like")
        {
            if($receiver_id == $about_id)
            {
                $message = "You Liked your Post 😉";
            }else
            {
                $message = $row['username'] . " Liked your Post 😁😀";
            }
            
        }

        if($type == "unlike")
        {
            if($receiver_id == $about_id)
            {
                $message = "You Unliked your Post 🤨";
            }else
            {
                $message = $row['username'] . " Unliked your Post 😓😔";
            }
            
        }

        $sql = "INSERT INTO notifications (
            user_id,about_id,message,type,status,post_id
        ) 
        VALUES(
            '$receiver_id','$about_id','$message','$type','$status','$post_id'
        )";

        // return $sql;
        return $DB->save($sql);
    }

    public function insert_token_notification($user_id,$token)
    {
        $DB = new DB();
        $status = 0;
        $message = "Click to move to the admin page or copy token";
        $type="token";
        $sql = "INSERT INTO notifications (
                    user_id,about_id,message,type,status
                ) 
                VALUES(
                    '$user_id','$token','$message','$type','$status'
                )";
                // print_r($sql);
                // die();
                return $DB->save($sql);
    }
    public function insert_post_notification($about_id,$type,$post_id)
    {
        $DB = new DB();
        $about_id = addslashes($about_id);
        $post_id = addslashes($post_id);
        $friends = new Friends();
        $section = "friends";
        $friends = $friends->get_friends($about_id,$section);
        $user = new User();
        $row = $user->user_data($about_id)[0];
        $status = 0;

        if(is_array($friends) && count($friends) > 0)
        {
            

            $SQL =  "SELECT initial_id FROM post WHERE post_id = '$post_id'";
            $post_data = $DB->read($SQL)[0];
            $initial_id = $post_data['initial_id'];
            
            foreach ($friends as $friend_id) {
                $username = $user->user_data($friend_id)[0]['username'];
                if($type == "post")
                {
                    $message = $username. " Your Comrade " .$row['username'] . " Created a new Post. let\'s go check it out 🤗"; 
                }elseif ($type == "share") {
                    $message = $username. " Your Comrade " .$row['username'] . " Shared a new Post. let\'s go check it out 🤗"; 
                    if($friend_id == $initial_id)
                    {
                        $message = $username. " Your Comrade " .$row['username'] . " Share your Post. let\'s go check it out his caption 🤗"; 
                    }
                }
                

                $sql = "INSERT INTO notifications (
                    user_id,about_id,message,type,status,post_id
                ) 
                VALUES(
                    '$friend_id','$about_id','$message','$type','$status','$post_id'
                )";
                
                $DB->save($sql);
            }

            return "INSERTED";
        }

        
    }

    public function get_notific($userid)
    {
        $DB = new DB();
        $sql = "SELECT * FROM notifications WHERE user_id = '$userid'  ORDER BY id DESC LIMIT 15";
        $result = $DB->read($sql);
        return $result;
    }

    public function read_notification($userid)
    {
        $DB = new DB();
        $notific = $this->get_notific($userid);
        if(is_array($notific) && $notific != false)
        {
            foreach ($notific as $row) {
                $sql = "UPDATE notifications SET status = '1' WHERE id = '$row[id]' ";
                $DB->save($sql);
            }
        }
    }

    public function insert_slogan_change_notification($group_id,$type)
    {
        $DB = new DB();
        $group_id = addslashes($group_id);
        $status = 0;
        
        $sql = "SELECT members,group_name FROM groups WHERE group_id = '$group_id'";
        if($members = $DB->read($sql)[0])
        {
            $group_name = $members['group_name'];
            $members = $members['members'];
            $members = json_decode($members,true);
            $message = "The Slogan of " . $group_name . " has been changed. Go check it out 🙃";

            foreach ($members as $member) {
                $sql = "INSERT INTO notifications (
                    user_id,about_id,message,type,status
                ) 
                VALUES(
                    '$member','$group_id','$message','$type','$status'
                )";

                $DB->save($sql);
            }
        }
    
    }
}

class Friends
{

    
    public function get_friends($userid,$section)
    {
        $DB = new DB();
        $friends = [];
        $Followers = [];
        $Following = [];
        // $followers_ids = [];

        /** Get FOllowers */
        $sql = "SELECT followers_ids FROM users WHERE user_id = '$userid'";
        $result2 = $DB->read($sql);
        if(is_array($result2))
        {
            if(!is_null($result2[0]['followers_ids']))
            {
                $followers_ids = json_decode($result2[0]['followers_ids'],true);
                
                if(is_array($followers_ids))
                {
                    for ($i=0; $i < count($followers_ids); $i++) {
                        if(!in_array($followers_ids[$i],$friends))
                        {
                            $friends[] = $followers_ids[$i];
                        }
                        $Followers[] = $followers_ids[$i];
                    }
                }
                
            }
           
            
        }

        /** Get Following */

        $sql = "SELECT following_ids FROM users WHERE user_id = '$userid'";
        $result2 = $DB->read($sql);
        if(is_array($result2))
        {
            if(!is_null($result2[0]['following_ids']))
            {
                $following_ids = json_decode($result2[0]['following_ids'],true);
                
                if(is_array($following_ids))
                {
                    for ($i=0; $i < count($following_ids); $i++) { 
                        if(!in_array($following_ids[$i],$friends))
                        {
                            $friends[] = $following_ids[$i];
                        }
                        $Following[] = $following_ids[$i];
                    }
                }
                
            }
            
            
        }


        if($section == "followers")
        {
            return $Followers;
        }
        elseif($section == "following")
        {
            return $Following;
        }
        elseif($section == "friends")
        {
            return $friends;
        }
        
    }

    public function In_friends($friend_id, $user_id,$section)
    {
        $following = $this->get_friends($friend_id,"following");
        $followers = $this->get_friends($friend_id,"followers");

        if($section == "following")
        {
            return in_array($user_id,$following);
        }else{
            return in_array($user_id,$followers);
        }
    }

    public function Follow($friend_id,$user_id)
    {
        $DB = new DB();
        $Notify = new Notify();
        // ! Updating the followers of friend
        $followers_ids = $this->get_friends($friend_id,"followers");
        $followers_ids[] = $user_id;
        $followers_ids = json_encode($followers_ids);
        $sql = "UPDATE users SET followers_ids = '$followers_ids' WHERE user_id = '$friend_id'";
        $savedfriend = $DB->save($sql);

        // *Increment followers count of friend;
        $sql = "UPDATE users SET followers = followers + 1 WHERE user_id = '$friend_id'";
        $increaseFriend = $DB->save($sql);

        // * Notify friend of an added follow
        $notifyFriend = $Notify->insert_Follow_notification($friend_id,$user_id,"follow");

        // ! Updating following of user
        $following_ids = $this->get_friends($user_id,"following");
        $following_ids[] = $friend_id;
        $following_ids = json_encode($following_ids);
        $sql = "UPDATE users SET following_ids = '$following_ids' WHERE user_id = '$user_id'";
        $savedUser =  $DB->save($sql);

        // *Increment followers count of friend;
        $sql = "UPDATE users SET following = following + 1 WHERE user_id = '$user_id'";
        $increaseUser = $DB->save($sql);

        if($savedfriend && $savedUser && $increaseFriend && $notifyFriend && $increaseUser)
        {
            return true;
        }else{
            return false;
        }
    }

    public function Unfollow($friend_id,$user_id)
    {
        $DB = new DB();
        $Notify = new Notify();
        $newFollowers = [];
        $newFollowing = [];
        // ! Updating the followers of friend
        $followers_ids = $this->get_friends($friend_id,"followers");
        $key = array_search($user_id,$followers_ids);
        // todo Remove the user_id from friends followers
        unset($followers_ids[$key]);

        // ! Copy followers into anew Array
        foreach ($followers_ids as $id) {
            $newFollowers[] = $id;
        }

        $followers_ids = json_encode($newFollowers);
        $sql = "UPDATE users SET followers_ids = '$followers_ids' WHERE user_id = '$friend_id'";
        $savedfriend = $DB->save($sql);

        // *Decrement followers count of friend;
        $sql = "UPDATE users SET followers = followers - 1 WHERE user_id = '$friend_id'";
        $increaseFriend = $DB->save($sql);

        // * Notify friend of a removed follow
        $notifyFriend = $Notify->insert_Follow_notification($friend_id,$user_id,"unfollow");

        // ! Updating following of user
        $following_ids = $this->get_friends($user_id,"following");
        $key = array_search($user_id,$following_ids);
        // todo Remove the user_id from friends followers
        unset($following_ids[$key]);

        // ! Copy followers into anew Array
        foreach ($following_ids as $id) {
            $newFollowing[] = $id;
        }

        $following_ids = json_encode($newFollowing);
        $sql = "UPDATE users SET following_ids = '$following_ids' WHERE user_id = '$user_id'";
        $savedUser =  $DB->save($sql);

        // *Increment followers count of friend;
        $sql = "UPDATE users SET following = following - 1 WHERE user_id = '$user_id'";
        $increaseUser = $DB->save($sql);

        if($savedfriend && $savedUser && $increaseFriend && $notifyFriend && $increaseUser)
        {
            return true;
        }else{
            return false;
        }
    }

    
}

class User
{
    public function user_data($userid)
    {
        $sql = "SELECT * FROM users WHERE user_id = '$userid'";
        $DB = new DB();
        $result = $DB->read($sql);
        return $result;
    }
}

class Chat 
{
    public function update_typing($user_id,$friend_id)
    {
        $DB = new DB();
        $sql = "UPDATE chats SET typing = '' WHERE (incoming_id = '$user_id' && outgoing_id = '$friend_id') || (incoming_id = '$friend_id' && outgoing_id = '$user_id')";
        $result = $DB->save($sql);
        return $result;
    }

    private function userFriend_update_history($user_id,$friend_id)
    {
        $DB = new DB();
        $history = [];

        
        $sql = "SELECT history FROM users WHERE user_id = '$user_id'";
        if($result = $DB->read($sql))
        {
            $result = $result[0]['history'];
            if(!is_null($result))
            {
                $history = json_decode($result,true);
                if(is_array($history))
                {
                    $index = array_keys($history,$friend_id);
                    if($index)
                    {
                        unset($history[$index[0]]); 
                    }

                }
            }
            array_unshift($history,$friend_id);
            $history = json_encode($history);
            $sql = "UPDATE users SET history = '$history' WHERE user_id = '$user_id'";
            return $DB->save($sql);
        }
    }

    public function userGroup_update_history($members,$group_id)
    {
        $DB = new DB();
        
        if(is_array($members))
        {
            foreach ($members as $user_id) {   
                $history = [];
                $sql = "SELECT group_history FROM users WHERE user_id = '$user_id'";
                if($result = $DB->read($sql))
                {
                    $result = $result[0]['group_history'];
                    if(!is_null($result))
                    {
                        $history = json_decode($result,true);
                        if(is_array($history))
                        {
                            $index = array_keys($history,$group_id);
                            if($index)
                            {
                                unset($history[$index[0]]); 
                            }

                        }
                    }
                    array_unshift($history,$group_id);
                    $history = json_encode($history);
                    $sql = "UPDATE users SET group_history = '$history' WHERE user_id = '$user_id'";
                    $DB->save($sql);
                } 
            }

            return true;
        }
        
    }

    public function update_history($user_id,$friend_id)
    {
        /** Update Logged user's history */
        $priv_update1 = $this->userFriend_update_history($user_id,$friend_id);
        $priv_update2 = $this->userFriend_update_history($friend_id,$user_id);
        if($priv_update1 && $priv_update2)
        {
            return true;
        }else{
            return false;
        }

    }
}

class Generate
{
    public function random($len,$type = "mixed")
    {
        $random = "";
        $index = false;
        if($type == "mixed"){$characters = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM";}
        elseif($type == "int"){$characters = "1234567890";}
        elseif($type == "text"){$characters = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";}
        
        for ($i=0; $i < $len; $i++) { 
            $index = rand(0,strlen($characters)-1);
            $random .= $characters[$index];
        }

        return $random;
    }
}

class Post
{
    public function repost($initial_id,$user_id,$caption,$post_id)
    {
        $DB = new DB();
        $generate = new Generate();
        $notify = new Notify();

        $sql = "SELECT * FROM post WHERE post_id = '$post_id'";
        $post_data = $DB->read($sql)[0];
        $likes = 1;
        $img =  $post_data['img'];
        $post_id = $generate->random(11);
        if($post_data['img'] != NULL)
        {
            $query = "INSERT INTO post(initial_id,post_id,caption,user_id,img,likes) VALUES('$initial_id','$post_id','$caption','$user_id','$img','$likes')";
        }else{
            $query = "INSERT INTO post(initial_id,post_id,caption,user_id,likes) VALUES('$initial_id','$post_id','$caption','$user_id','$likes')";
        }

        $result = $DB->save($query);
        $sql = "UPDATE post SET shares = shares + 1 WHERE post_id = '$post_data[post_id]'";
        $DB->save($sql);

        /** Notify User */
        $notify->insert_post_notification($user_id,"share",$post_id);
        return $result;
        
       
    }

}

class Story{
    public function check_story($time,$post_id)
    {
        $DB = new DB();
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");
        $diff = time() - strtotime($time);
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        if($diff >= 2 && $strTime[$i] == "day")
        {
            $sql = "DELETE FROM stories WHERE post_id = '$post_id'";
            return $DB->save($sql);
        }else{
            return false;
        }
    }

    public function verify_image($image)
    {
        $extension = ['image/png','image/jpg','image/jpeg'];
        if(in_array(strtolower($image['type']),$extension))
        {
            return true;
        }else{
            return false;
        }
    }
}

class Time
{
    public function timeago($date) {
	   $timestamp = strtotime($date);	
	   
	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff = time()- $timestamp;
            
            
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			    $diff = $diff / $length[$i];
			}
            
			$diff = round($diff);
            
            // if($diff == 0)
            // {
            //     return "Just Now";
            // }
			return $diff . " " . $strTime[$i] . "(s) ago ";
	   }
	}
}

/** FUNCTIONS */


function is_blocked($user_id,$incoming_id)
{
    $user = new User();
    $blocked = $user->user_data($user_id)[0]['blocked'];
    if(!is_null($blocked))
    {
        $blocked = json_decode($blocked,true);
        if(is_array($blocked))
        {
            if(in_array($incoming_id,$blocked))
            {
                return true;
            }
        }
    }return false;
}

function am_blocked($user_id,$incoming_id)
{
    $user = new User();
    $blocked = $user->user_data($incoming_id)[0]['blocked'];
    if(!is_null($blocked))
    {
        $blocked = json_decode($blocked,true);
        if(is_array($blocked))
        {
            if(in_array($user_id,$blocked))
            {
                return true;
            }
        }
    }return false;
}

function is_admin($user_id,$groupid)
{
    $DB = new DB();
    $sql = "SELECT admin_id FROM groups WHERE group_id = '{$groupid}'";
    if($admin = $DB->read($sql))
    {
        $admin = $admin[0]['admin_id'];
        if($user_id == $admin)
        {
            return true;
        }
    }

    return false;
    
}
