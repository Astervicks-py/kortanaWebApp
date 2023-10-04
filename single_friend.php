<?php
$followBtn = "";
if(!in_array($row['user_id'],$followers_ids) && !in_array($row['user_id'],$following_ids))
{
    $followBtn = "Follow";
}
else if(in_array($row['user_id'],$followers_ids) && !in_array($row['user_id'],$following_ids))
{
    $followBtn = "Follow Back";
}
else if(in_array($row['user_id'],$following_ids))
{
    $followBtn = "Unfollow";
}

?>


<div class="friend">
    <a href="./friends_profile_page.php?id=<?php echo $row['user_id'] ?>" class="top">
        <img class="profile_pic" src="./includes/<?php echo $row['profile_pic'] ?>">
        <div class="friend-name">
            <h4 style="display:flex;gap:5px;"><?php echo $row['username'] ?> <?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h4>
            <h5 style="display:inline-block;margin-right:8px"><?php echo $row['followers'] ?> Followers</h5>
            <h5 style="display:inline-block;margin-right:8px">Following <?php echo $row['following'] ?></h5>
        </div>
    </a>
    <div class="bottom">
        <a onclick="follow(this)" id="follow-btn" data-id="<?php echo $row['user_id'] ?>" ><?php echo $followBtn ?></a>
    </div>
</div>