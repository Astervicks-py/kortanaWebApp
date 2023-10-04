<?php

session_start();
require_once "config.php";
require_once "classes.php";
$user_id = $_SESSION['id'];
$friends = new Friends();
$user_cls = new User();
$user_cls = new User();
$DB = new DB();
$followers_ids = $friends->get_friends($user_id,"followers");
$following_ids = $friends->get_friends($user_id,"following");

// echo "<pre>";
// print_r($following_ids);
// print_r($followers_ids);
// echo "<pre/>";
// die();
$output = "";

$sql = "SELECT * FROM users WHERE NOT user_id = '$user_id'";
if($result = $DB->read($sql)){

    foreach($result as $row){
        $is_verifed = $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "";
        if(in_array($row['user_id'],$followers_ids) && !in_array($row['user_id'],$following_ids))
        {
            $output .= '
                <div class="friend">
                    <a href="./friends_profile_page.php?id='.$row['user_id'].'" class="top">
                        <img class="profile_pic" src="./includes/'.$row['profile_pic'].'">
                        <div class="friend-name">
                            <h4 style="display:flex;gap:5px;">'.$row['username']. $is_verifed .'</h4>
                            <h5 style="display:inline-block;margin-right:8px">'.$row['followers'].' Followers</h5>
                            <h5 style="display:inline-block;margin-right:8px">Following '.$row['following'].'</h5>
                        </div>
                    </a>
                    <div class="bottom">
                        <button style="cursor:pointer" id="follow-btn" onclick="follow(this)" data-id="'.$row['user_id'].'" >Follow Back</button>
                    </div>
                </div>
            
            ';
        }
        
    }
    if($output == "")
    {
        $output .=
        '
            <div class="friend" style="width:100%;justify-content:center;">
                <div class="top" style="color:#fff;text-align:center;width:100%;display:block;font-size:3rem">
                    No new Desiree 🤗
                </div>
                
            </div>
        ';

    }
    
    echo $output;
}