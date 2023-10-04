<?php 

    require_once "./includes/config.php";
    session_start();

    if(isset($_SESSION['id'])){
        $sql = "SELECT * FROM users WHERE user_id = '{$_SESSION['id']}'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);
            // echo "<script>alert('{$row['user_id']}')</script>";
        }

    }else{
        header('location:./signup.php');
        die();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kortana</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.min.css">
    <link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./video_page/video.css">
</head>
<style>
    .feeds
    {
        margin-top:2vh;
    }
</style>
<body>

    
    <div class="loading-container">
        <div class="ring"></div>
        <span>Loading...</span>
    </div>

    <nav>
        <div class="container">
            <div class="logo">
                <img src="./Kortana-logo-full.png"> 
            </div>
            <div class="create">
                <label class="btn btn-primary"><a href="home.php" style="color:#fff;">Posts</a></label>
                <label class="btn btn-primary active"><a href="video.php" style="color:#fff;">Videos</a></label>
                <label class="btn btn-primary"><a href="video-post.php" style="color:#fff;">Create</a></label>
                <a href="profile.php" class="profile-pic">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </a>
            </div>
        </div>
    </nav>

    <!-- =================  Main Content ==================== -->

    <main>
        <div class="container">
            <!-- ------------- Left Side  --------------- -->
            <div class="left">
                <a class="profile">
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>">
                    </div>
                    <div class="handle">
                        <h4 style="font-size:1.2rem;"><?php echo $row['fname'].' '.$row['lname'] ?></h4>
                        <p class="text-muted">
                        @_<?php echo $row['username'] ?>
                        </p>
                    </div>
                </a>

                <!-- --------side bar----------- -->
                <div class="side-bar">
                    <a class="menu-item active">
                        <span><i class="fa fa-home"></i></span><h3>Home</h3>
                    </a>
                    <a href="explore_page.php" class="menu-item">
                        <span>
                            <i class="fa fa-user-friends"></i>
                        </span>
                        <h3>Explore</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                        <span>
                            <i class="fa fa-bell"></i>
                            <small class="notification-count">6+</small>
                        </span>
                        <h3>Notification</h3>
                        <!---------- Notification Popup ---------------->
                        <div class="notification-popup">
                            <div class="notification-box">
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-9.jpeg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Chadwick Boseman </b> Accepted your friend request
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-10.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>H-Net</b>Accepted your friend request
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-12.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Clara </b>Liked your Post
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-13.jpeg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Clara </b>Commented on a post you were tagged in
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-4.jpeg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Victone </b>Commented on a post you were tagged in
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
                                    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-5.jpeg">
                                    </div>
                                    <div class="notification-body">
                                        <b>H-Ninja </b>Accepted your friend request
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
    
                                <div class="notific">
                                    <div class="profile-pic">
                                        <img src="./images/profile-pics/channel-6.jpeg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Mr Beast </b>Drop a message for you
                                        <small class="text-muted">2 days ago</small>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </a>
                    <a class="menu-item" id="messages-notification">
                        <span>
                            <i class="fa fa-envelope"></i>
                            <small class="notification-count">9+</small>
                        </span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item theme" id="theme">
                        <span><i class="fa fa-palette"></i></span>
                        <h3>Theme</h3>
                        <div class="theme-page">
                            <div class="theme-pick white"></div>
                            <div class="theme-pick dark"></div>
                            <div class="theme-pick black"></div>
                        </div>
                    </a>
                    <a class="menu-item" href="./includes/logout.inc.php">
                        <span><i class="fa-solid fa-forward"></i></span>
                        <h3>Logout</h3>
                    </a>
                    <a class="menu-item" href="#">
                        <span><i style="font-weight:bold;"class="fa-solid fa-arrow-up"></i></span>
                        <h3>Back to top</h3>
                    </a>
                </div>
                <label class="btn btn-primary" for="create-post">
                    Create Post
                </label>
            </div>

            <!-- ------------- Middle  --------------- -->
            <div class="middle">

                <!-- ----------- FEEDS ----------- -->
                <div class="feeds" id="video">
                    <div class="test"></div>
                    <!--To be inserted in the php &/|| javaScript  -->
                    <div class="video" >
                        <video src="./Snapchat-1684372684.mp4" autoplay="off" loop></video>
                        <div class="caption">
                            <div class="bgc"></div>
                            <div class="text">
                                <div class="details">
                                    <p>This is a video caption </p>
                                    <div class="follow">
                                        <p class="user" style="color:blue; text-transform: uppercase;">Astervicks.js</p>
                                    
                                    </div>
                                </div>
                                <div class="profile_pic">
                                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                </div>
                            </div>
                            <marquee><i class="fa fa-music"></i> This is a test of marquee to know how cool it is</marquee>
                            
                            
                        </div>
                        <div class="sidebar">
                            <button class="like-btn"><i class="icon fa fa-heart"></i><span>1k</span></button>
                            <button class="comment-btn"><i class="icon fa fa-comment"></i><span>512</span></button>
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
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                    
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                    
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
                                        </div>
                                        <div class="text">
                                            <h5>Astervicks.js</h5>
                                            <p>You too bad guy. 😁</p>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="profile_pic">
                                            <img src="./includes/<?php echo $row['profile_pic'] ?>">
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
                </div>
            </div>

            <!-- ------------- right Side  --------------- -->
            <div class="right">
                <!-- Messages -->
                <div class="messages" id="massages-tab" >
                    <h4><b>Messages</b></h4>
                    <div class="search-bar">
                        <i class="fa fa-search"></i>
                        <input type="search" placeholder="Search..">
                    </div>
                    <div class="head">
                        <span>Message</span>
                    </div>
                    
                    <div id="messages">
                        <!-- To be added in javaScript -->
                    </div>
                </div>

                <!-- Friend Request -->
                <div class="friend-request" >
                    <h4>Friend Request</h4>

                    <div id="friend-request">
                        <!--To be added in javascript  -->
                    </div>
                    
                </div>
            </div>
        </div>
        
    </main>

    
</body>
<script src="./loader.js"></script>
<script src="./video_page/script.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<!-- <script src="./javascript/home_page.js"></script> -->
</html>