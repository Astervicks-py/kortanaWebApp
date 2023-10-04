<?php
    session_start();
    require_once "classes.php";
    /** Declarations */
    $DB = new DB();
    $notify = new Notify();
    $user_id = $_SESSION['id'];
    $friend_id = addslashes($_POST['friend_id']);
    $Friends = new Friends();
    $friend_followers = $Friends->get_friends($friend_id,"followers");
    $user_following = $Friends->get_friends($user_id,"following");
    // var_dump($friend_followers);
    // var_dump($user_following);
    // echo $friend_id;

    // !Check if i am already one of his followers
    if($Friends->In_friends($friend_id,$user_id,"followers"))
    {
        // ? I am one of his followers therefore operation is to unfollow
        $Friends->Unfollow($friend_id,$user_id);
        echo "UNFOLLOWED";

    }else{
        // ? I am one of his followers therefore operation is to unfollow
        $Friends->Follow($friend_id,$user_id);
        echo "FOLLOWED";
    }

?>