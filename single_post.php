
<?php

    $post_id = $row['post_id'];
    $sql2 = "SELECT * FROM comments WHERE post_id = '$post_id' ";
    if($data = mysqli_query($conn,$sql2))
    {
        $no_comment = mysqli_num_rows($data);
    }

    /** Determine If the logged user has liked the post */
    $color = "#fff";
    

    if($row['img'] != NULL){

        /** With Img */
        $share = '<a style="font-size:1.5rem; color:#fff;" href="./comment/share.php?id='.$row['post_id'].'">
                    <i class="fa fa-share" data-id="'.$row['post_id'].'"></i><span>'.$row['shares'].'</span>
                </a>';

        $caption = '<div class="caption" style="background:var(--color-black);width:100%;padding:3px 5px">
                        <p>'.$row['caption'].' </p>
                    </div>';

        $img = '
                <a  href="fullscreen.php?section=post&id='.$row['post_id'].'" class="photo">
                    <img src="./includes/'.$row['img'].'">
                </a>';

        $feed = '<div class="feed" style="padding:5px 0px">';

    }else{
        /** Without iMg */

        $feed = '<div class="feed">';
        $img = '';
        $share = '';
        $caption = '<div class="caption" style="background:var(--color-dark);padding:var(--card-padding); border-radius:10px; margin:1rem 0; width:100%;">
                        <p style="font-size:1.4rem;">'.$row['caption'].' </p>
                    </div>';

    }

    $likes =$row['likes'];
    /** People that liked */
    $who_liked = "";
    $likes_sql = "SELECT likes FROM likes WHERE post_id = '$row[post_id]'";
    if($likes_result = $DB->read($likes_sql))
    {
        $likes_json = json_decode($likes_result[0]['likes'],true);
        /** Check if the user have liked */
        $user_ids = array_column($likes_json,"user_id");
        if(in_array($user_id,$user_ids) and count($user_ids) == 2)
        {
            $who_liked = "<b>You</b> Liked this";

        }elseif (in_array($user_id,$user_ids) && $user_ids[0] != $user_id && count($user_ids) == 3) {
            $extra_sql = "SELECT username FROM users WHERE user_id = '$user_ids[0]'";
            $extra_person = $DB->read($extra_sql)[0]['username'];
            $who_liked = "<b>You</b> and <b>" . $extra_person . "</b> Liked";

        }elseif (in_array($user_id,$user_ids) && $user_ids[0] != $user_id && count($user_ids) > 2) {
            $extra_sql = "SELECT username FROM users WHERE user_id = '$user_ids[0]'";
            $extra_person = $DB->read($extra_sql)[0]['username'];
            $who_liked = "<b>You</b>, <b>" . $extra_person . "</b> and " . $likes - 2 . " Others Liked";

        }elseif(count($user_ids) == 0){
            $who_liked = "";
        }else{
            $extra_sql = "SELECT username FROM users WHERE user_id = '$user_ids[0]'";
            $extra_person = $DB->read($extra_sql)[0]['username'];
            $who_liked = "<b>".$extra_person . "</b> and " .$likes - 1 ." Others Liked";
        }
    }else
    {
        $who_liked = "";
    }

    $time = new Time();
?>


<?php echo $feed ?>
    <div class="user">
        <div class="profile-pic">
            <img src="./includes/<?php echo $row['profile_pic'] ?>">
        </div>
        <div class="ingo">
            <h3 style="display:flex;gap:5px;"><?php echo $row['username'] ?> <?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h3>
            <small style="color:#0f0;"><span style="color:#fff"><?php echo $row['location']?></span> <?php echo $time->timeago($row['time']) ?></small>
        </div>
        <span class="edit">
            <i class="fa fa-ellipsis"></i>
        </span>
    </div>

    <?php echo $img ?>

    <?php echo $caption ?>

    <div class="action-btns" style="padding:3px 5px">
        <div class="interaction-btns">
            <?php
                $sql = "SELECT likes FROM likes WHERE post_id = '$post_id' LIMIT 1";
                $RESULT = $DB->read($sql);
                if(is_array($RESULT))    
                {
                    /** Convert the retrived likes back to array */
                    $likes = json_decode($RESULT[0]['likes'],true);
                    /** Check if the user have liked */
                    $user_ids = array_column($likes,"user_id");
                    // echo "<pre>";
                    // var_dump($user_ids);
                    // die();
                    // echo "</pre>";
                    if(in_array($user_id,$user_ids))
                    {
                        $color= "red";
                    }
                }
            
            ?>
            <a onclick="ajax_data(event,this)" style="font-size:1.5rem; color:<?php echo $color ?>;" href="./like.php?id=<?php echo $row['post_id'] ?>">
                <i class="fa fa-heart" ></i><span class="like-count"><?php echo $row['likes'] ?></span>
            </a>
            <a style="font-size:1.5rem; color:#fff;" href="./comment/comment.php?id=<?php echo $row['post_id'] ?>">
                <i class="fa fa-comment" data-id="<?php echo $row['post_id'] ?>"></i><span><?php echo $no_comment ?></span>
            </a>
            <?php echo $share ?>
        </div>
        <div class="bookmark">
            <span>
                <i class="fa fa-bookmark"></i>
            </span>
        </div>
        
    </div>

    <div class="people_liked"><?php echo $who_liked ?></div>
    <div class="text-muted comments" style="padding:3px 5px">
        <a style="color:#fff;" href="./comment/comment.php?id=<?php echo $row['post_id'] ?>">view all <?php echo $no_comment ?> comments</a>
    </div>
</div>

<script>
    function $(element)
    {
        return document.querySelector(element);
    }

    function ajax_data(e,ele) {
        e.preventDefault();
        var link = ele.href;
        let num = ele.querySelector(".like-count").textContent;
        console.log(num);
        // return;
        if(ele.style.color == "red")
        {
            ele.style.color = "#fff";
            num--;
            ele.querySelector(".like-count").innerHTML = num;      
        }else{
            ele.style.color = "red"; 
            num++;
            ele.classList.add('liked');
            setTimeout(() => {
                ele.classList.remove('liked');
            }, 1000);
            ele.querySelector(".like-count").innerHTML = num;  
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST","./includes/like_post.inc.php",true);
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