<?php

    require_once "classes.php";
    session_start();
    $user_id = $_SESSION['id'];
    $DB = new DB();
    $notify = new Notify();
    $user = new User();
    $output = "";
    $notifications = $notify->get_notific($user_id);
    $time = new Time();

    
    if(is_array($notifications))
    {
        // var_dump( $notifications);
        // die();
        foreach ($notifications as $notific) {
            $id = $notific['about_id'];
            // echo $id;
            // die();
            if($USER = $user->user_data($id))
            {
                $USER = $user->user_data($id)[0];
                $profile_pic = $USER['profile_pic'];
            }
            
            $color = "#fff";
            if($notific['status'] == 0)
            {
                $color = "#0f0";
            }

            

            if($notific['type'] == "post")
            {
                $header = '<a href="comment/comment.php?id='.$notific['post_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" href="./comment/like.php?id='.$notific['post_id'].'" class="notific">';

            }elseif($notific['type'] == "token")
            {
                $header = '<a href="./ADMIN_PAGE.php?token='.$notific['about_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" href="./ADMIN_PAGE.php?token='.$notific['about_id'].'" class="notific">';

            }elseif($notific['type'] == "unblocked" || $notific['type'] == "blocked")
            {
                $header = '<a href="chat_page.php?id='.$notific['about_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" href="./comment/like.php?id='.$notific['post_id'].'" class="notific">';
            }else if($notific['type'] == "like" || $notific['type'] == "unlike")
            {
                $header = '<a href="comment/like.php?id='.$notific['post_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" href="./comment/like.php?id='.$notific['post_id'].'" class="notific">';
    
            }else if($notific['type'] == "follow" || $notific['type'] == "unfollow")
            {
                $header = ' <a href="./friends_profile_page.php?id='.$notific['about_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" href="./comment/like.php?id='.$notific['post_id'].'" class="notific">';
               
            }elseif($notific['type'] == "slogan")
            {
                $sql =  "SELECT group_dp FROM groups WHERE group_id = '$notific[about_id]'";
                $profile_pic = $DB->read($sql)[0]['group_dp'];
                $header = '<a href="./group_info_page.php?id='.$notific['about_id'].'" style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" class="notific">';
            }
            else{
                $header ='<div style="color:'.$color.';width:100%;display:flex;gap:1rem;border:solid 1px var(--color-border);border-radius:5px" class="notific">';
            }
            if($notific['type'] != "token")
            {
                $section = '
                    <div class="profile-pic" style="min-height:40px !important;min-width:50px !important">
                            <img src="./includes/'.$profile_pic.'">
                        </div>
                ';
            }else{
                $section = '<div>
                    <button style="padding:15px;background:var(--color-dark);color:#fff;cursor:pointer;" data-content="'.$notific['about_id'].'" class="copy-btn" onclick="copyNote(this)">COPY</button>
                </div>';
            }
            $output .= 
                '
                    '.$header.'
                        '.$section.'
                        <div class="notification-body">
                            '.$notific['message'].'
                            <small style="color:var(--color-border)" class="text-muted">'.$time->timeago($notific['time']).'</small>
                        </div>
                    </div>
                ';
            
        }
    }
    

    echo $output;
?>