<?php
    require_once "config.php";
    require_once "./classes.php";
    

    session_start();
    $DB = new DB();
    $user_id = $_SESSION['id'];
    $output = '';
    $sql = "SELECT * from post RIGHT JOIN users ON users.user_id = '{$user_id}' WHERE post.user_id = '{$user_id}'";
    $share = '';
    $color = '#fff';
    $script = '
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
                    ele.classList.add("liked");
                    setTimeout(() => {
                        ele.classList.remove("liked");
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
    ';
       
    if($result = mysqli_query($conn,$sql)){
        while($row = mysqli_fetch_assoc($result)){
            $post_id = $row['post_id'];
            /** People that liked */
            $who_liked = "";
            $likes_sql = "SELECT likes FROM likes WHERE post_id = '$post_id'";
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
                    $who_liked = "<b>".$extra_person . "</b> and " .$row["likes"] - 1 ." Others Liked";
                }
            }else
            {
                $who_liked = "";
            }
            $sql2 = "SELECT * FROM comments WHERE post_id = '$post_id' ";
            if($data = mysqli_query($conn,$sql2))
            {
                $no_comment = mysqli_num_rows($data);
            }
            if($row['img'] != NULL){
                $post_Section = '
                    <a  href="fullscreen.php?section=post&id='.$row['post_id'].'" class="photo">
                        <img src="./includes/'.$row['img'].'">
                    </a>

                    <div class="caption" style="
                        background:var(--color-black);width:100%;padding:3px 5px">
                            <p>
                                
                                '.$row['caption'].'
                                
                            </p>
                    </div>
                ';

                $share = '  
                            <a style="font-size:1.5rem; color:#fff;" href="./comment/share.php?id='.$row['post_id'].'">
                                <i class="fa fa-share" data-id="'.$row['post_id'].'"></i><span>'.$row['shares'].'</span>
                            </a>
                        ';
                

                
            }else{
                /** Without Img */
                $share = '';
                $post_Section = '
                    <div class="caption" style="
                        background:var(--color-black);width:100%;padding:3px 5px">
                            <p>
                                
                                '.$row['caption'].'
                                
                            </p>
                    </div>

                ';
            }
            
                $output .= 
                '
                    <div class="feed">
                        <div class="user">
                            <div class="profile-pic">
                                <img src="./includes/'.$row['profile_pic'].'">
                            </div>
                            <div class="ingo">
                                <h3>'.$row['username'].'</h3>
                                <small>Dubai 24 minutes ago</small>
                            </div>
                            <span class="edit">
                                <i class="fa fa-ellipsis"></i>
                            </span>
                        </div>
                    
                        '.$post_Section.'

                        <div class="action-btns">
                            <div class="interaction-btns">
                                <a onclick="ajax_data(event,this)" style="font-size:1.5rem; color:'.$color.';" href="./like.php?id='. $row['post_id'] .'">
                                    <i class="fa fa-heart" ></i><span class="like-count">'.$row['likes'] .'</span>
                                </a>
                                <a style="font-size:1.5rem; color:#fff;" href="./comment/comment.php?id='.$row['post_id'].'">
                                    <i class="fa fa-comment" data-id="'.$row['post_id'].'"></i><span>'.$no_comment.'</span>
                                </a>
                                
                                '.$share.'
                            </div>
                            <div class="bookmark">
                                <a style="font-size:1.5rem; color:#f00;" href="./comment/delete.php?id='.$row['post_id'].'">
                                    <i class="fa fa-remove" data-id="'.$row['post_id'].'"></i>
                                </a>
                            </div>
                        </div>
                
                        <div class="liked-by">
                            
                            <div class="people_liked">'. $who_liked .'</div>
                        </div>
                
                        <div class="text-muted comments" style="padding:3px 5px">
                            <a style="color:#fff;" href="./comment/comment.php?id='.$row['post_id'].'">view all '.$no_comment.' comments</a>
                        </div>
                    </div>
                    '.$script.'
                ';
        }
        echo $output;
    }
?>