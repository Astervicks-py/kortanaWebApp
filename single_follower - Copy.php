<div class="friend">
    <div class="top">
        <img class="profile_pic" src="./includes/<?php echo $row['profile_pic'] ?>">
        <a style="display:flex;align-items:center" href="./friends_profile_page.php?id=<?php echo $row['user_id'] ?>">
            <h4 style="color:#fff;display:flex;gap:5px"><?php echo $row['username'] ?><?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h4>
        </a>
    </div>
    <div class="bottom">
        <button onclick="follow(this)" id="follow-btn" data-id="<?php echo $row['user_id'] ?>" ><?php echo $follow_btn ?></button>
    </div>
</div>
