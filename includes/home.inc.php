<?php
    session_start();
    require_once "config.php";
    require_once "classes.php";
    $user_id  = mysqli_real_escape_string($conn,$_SESSION['id']);
    $output = "";
    $no_comment = 0;
    $followers = [];
    $following = [];
    $DB = new DB();
    $friend = new Friends();

    /** Get friends i.e People that are being followed or following */
    $friends = $friend->get_friends($user_id,"friends");
    $limit = 20;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $page = $page >= 1 ? $page : 1;

    $offset = ($page - 1) * $limit;


    
    

    $sql = "SELECT * FROM post LEFT JOIN users ON users.user_id = post.user_id ORDER BY post.id DESC  LIMIT $limit OFFSET $offset";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt,$sql)){ 
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result) ){
                
                $post_id = $row['post_id'];
                $sql2 = "SELECT * FROM comments WHERE post_id = '$post_id' ";
                if($data = mysqli_query($conn,$sql2))
                {
                    $no_comment = mysqli_num_rows($data);
                }

                /** Determine If the logged user has liked the post */
                $color = "#fff";
                $sql = "SELECT likes FROM likes WHERE post_id = '$post_id' LIMIT 1";
                $RESULT = $DB->read($sql);
                if(is_array($RESULT))    
                {
                    /** Convert the retrived likes back to array */
                    $likes = json_decode($RESULT[0]['likes'],true);
                    /** Check if the user have liked */
                    $user_ids = array_column($likes,"user_id");

                    if(in_array($user_id,$user_ids))
                    {
                        $color= "red";
                    }
                }

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

                $output .= 
                    '
                        '.$feed.'
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
                        
                            '.$img.'

                            '.$caption.'

                            <div class="action-btns" style="padding:3px 5px">
                                <div class="interaction-btns">
                                    <a style="font-size:1.5rem; color:'.$color.';" href="./comment/like.php?id='.$row['post_id'].'">
                                        <i class="fa fa-heart" data-id="'.$row['post_id'].'"></i><span>'.$row['likes'].'</span>
                                    </a>
                                    <a style="font-size:1.5rem; color:#fff;" href="./comment/comment.php?id='.$row['post_id'].'">
                                        <i class="fa fa-comment" data-id="'.$row['post_id'].'"></i><span>'.$no_comment.'</span>
                                    </a>
                                    '.$share.'
                                </div>
                                <div class="bookmark">
                                    <span>
                                        <i class="fa fa-bookmark"></i>
                                    </span>
                                </div>
                            </div>
                    
                            
                            <div class="text-muted comments" style="padding:3px 5px">
                                <a style="color:#fff;" href="./comment/comment.php?id='.$row['post_id'].'">view all '.$no_comment.' comments</a>
                            </div>
                        </div>
                    ';
                    
                
            };
            echo $output;
        }
    }

