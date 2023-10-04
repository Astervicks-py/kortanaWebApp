<?php
    require_once "config.php";
    
    $output = '';
    $sql = "SELECT * from post RIGHT JOIN users ON users.user_id = '$user_id' WHERE post.user_id = '$user_id'";
    if($result = mysqli_query($conn,$sql)){
        while($row = mysqli_fetch_assoc($result)){
            $post_id = $row['post_id'];
            $sql2 = "SELECT * FROM comments WHERE post_id = $post_id ";
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
                                <a onclick="ajax_data(event,this)" style="font-size:1.5rem; color:'.$color.';" href="./comment/like.php?id='.$row['post_id'].'">
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
                            
                            <p>Liked by <b>jordan Achiever</b> and <b>2,456 others</b></p>
                        </div>
                
                        <div class="text-muted comments" style="padding:3px 5px">
                            <a style="color:#fff;" href="./comment/comment.php?id='.$row['post_id'].'">view all '.$no_comment.' comments</a>
                        </div>
                    </div>
                ';
        }
        echo $output;
    }
?>