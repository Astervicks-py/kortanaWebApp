<?php

require_once "config.php";
session_start();
$user_id = $_SESSION['id'];
$output = '';
$sql = "SELECT * FROM video_posts LEFT JOIN users ON users.user_id = video_posts.user_id ORDER BY video_id DESC";
if($result = mysqli_query($conn,$sql))
{
    if(mysqli_num_rows($result) > 0)
    {
        
        
        while($row = mysqli_fetch_assoc($result))
        {
            $video = $row['video'];
            $exploded = 'likes_'.strtolower(explode("/",$video)[1]);
            // echo $exploded;
            $sql2 = "SELECT * FROM `$exploded` ORDER BY likes DESC LIMIT 1";
            if($result2 = mysqli_query($conn,$sql2))
            {
                $row2 = mysqli_fetch_assoc($result2);

                $output .= 
                '
                <div class="video" >
                    <video src="./includes/'.$row['video'].'" autoplay="on" loop></video>
                    <div class="caption">
                        <div class="bgc"></div>
                        <div class="text">
                            <div class="details">
                                <p>'.$row['caption'].'</p>
                                <div class="follow">
                                    <p class="user" style="color:blue; text-transform: uppercase;">'.$row['username'].'</p>
                                
                                </div>
                            </div>
                            <div class="profile_pic">
                                <img src="./includes/'.$row['profile_pic'] .'">
                            </div>
                        </div>
                        <marquee><i class="fa fa-music"></i> This is a test of marquee to know how cool it is</marquee>
                        
                        
                    </div>
                    <div class="sidebar">
                        <button class="like-btn" onclick="like(this)"><i class="icon fa fa-heart"></i><span>'.$row2['likes'].'</span></button>
                        <button class="comment-btn" onclick="comment(this)"><i class="icon fa fa-comment"></i><span>512</span></button>
                    </div>
                    <div class="comments-cont">
                        <div class="header">
                            <button class="back-btn"><i class="fa fa-backward"></i></button>
                            <h3>Comments</h3>
                        </div>
                        <div class="comments">
                            <div class="com">
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                                <div class="comment">
                                    <div class="profile_pic">
                                        <img src="./includes/'.$row['profile_pic'].'">
                                    </div>
                                    <div class="text">
                                        <h5>Astervicks.js</h5>
                                        <p>You too bad guy. 😁</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <form class="textarea">
                                <textarea name="comment" id="comment" rows="1"></textarea>
                                <button><i class="fab fa-telegram-plane"></i></button>
                            </form>
                            
                        </div>
                        <div class="bgc"></div>
                        
                    </div>
                </div>
                ';
            }
            
        }

        echo $output;
    }
    
}