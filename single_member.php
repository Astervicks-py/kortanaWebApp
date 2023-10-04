<div class="friend">
    <div class="top">
        <img class="profile_pic" src="./includes/<?php echo $row['profile_pic'] ?>">
        <a style="display:flex;align-items:center" href="./friends_profile_page.php?id=<?php echo $row['user_id'] ?>">
            <h4 style="color:#fff;"><?php echo $row['username'] ?></h4>
        </a>
    </div>
    
    <div class="bottom">
        <?php if(is_admin($member,$group_id)):?>
            <a onclick="follow(event,this)" href="<?php echo $row['user_id'] ?>" >Admin</a>
            <?php else:?>
                <a onclick="follow(event,this)" href="<?php echo $row['user_id'] ?>" ><?php echo $follow_btn ?></a>
        <?php endif; ?>
        
        
    </div>
</div>

<script>

    function $(element){
        return document.querySelector(element);
    }

    function follow(e,elem) {
        e.preventDefault();
        var link = elem.href;
        if(elem.textContent == "Follow")
        {
            elem.textContent = "Unfollow";
        }else if(elem.textContent == "Follow Back")
        {
            elem.textContent = "Unfollow";
        }else{
            elem.textContent = "Follow";
        }
        // console.log(link);
        let xhr = new XMLHttpRequest();
        xhr.open("POST","./includes/outside_follow.inc.php",true);
        xhr.onload = () =>
        {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
            {
                let data = xhr.response;
                console.log(data);
                
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("link=" + link);
    }

</script>