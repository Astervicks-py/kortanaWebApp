<?php 
    require_once "profile_header.php";
    require_once "includes/classes.php";
    $DB = new DB();
    $friend = new Friends();
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    if($result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_assoc($result);
    }

    $query = "SELECT * FROM post WHERE user_id = '$user_id'";
    if($DB->read($query))
    {
        $post_no = count($DB->read($query));
    }else{
        $post_no = 0;
    }
    
?>
<link rel="stylesheet" href="custom_css/profile.css">
</head>
<style>
    .friend{
        width:100%;
        padding:var(--card-padding);
        border-radius:10px;
        display: grid;
        grid-template-columns:2fr 1fr;
        gap:10px;
        background:var(--color-dark);
        border:solid 2px var(--color-border);
        justify-content: space-between;
    }
    .stats
    {
        transition:1s;
    }

    .users_activity
    {
        scroll-snap-type:x mandatory;
    }

    .slide
    {
        scroll-snap-align:start;
    }
</style>

<body class="<?php echo $row['theme'] ?>"> 
    <div class="container">
        <div class="nav-bar">
            <a href="index.php"> <button><i class="fa fa-arrow-left-long"></i></button></a>
            <div class="name">
                <h1>#<?php echo $row['username']?></h1>
            </div> 
        </div>
        <header>
            <div class="bottom-sect">
                <form class="profile">
                    <a href="fullscreen.php?section=profile&id=<?php echo $row['user_id']?>">
                        <img src="./includes/<?php echo $row['profile_pic']?>" alt="">
                    </a>
                    
                    <div class="file">
                        <input type="file" name="profile">
                        <i class="fa fa-camera icons"></i>
                    </div>
                </form>
            </div>
            <div class="header">
                <div>
                    <h2 style="display:flex;gap:5px;"><?php echo $row['lname'].' '.$row['fname']?> <?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h2>
                    <p><?php echo ucfirst($row['gender'])?> <i class="fa fa-<?php echo $row['gender']?>"></i></p>
                </div>
                
                <div class="bio" style="margin-top:10px;">
                    <p><?php echo $row['bio']?></p>
                </div>
            </div>
        </header>
    </div>
    <div class="follow container">
        <a href="#posts" onclick="movePrimary(this)" class="stats" style="border-bottom:solid 3px var(--color-border)">
            <div>
                <span><?php echo $post_no ?></span>
            </div>
            <h3>Post</h3>
        </a>
        <a href="#followers" onclick="movePrimary(this)" class="stats">
            <div>
                <span><?php echo $row['followers'] ?></span>
            </div>
            <h3>Comrades </h3>
        </a>
        <a href="#following" onclick="movePrimary(this)" class="stats">
            <div>
                <span><?php echo $row['following'] ?></span>
            </div>
            <h3>Following </h3>
            
        </a>
    </div>

    <main class="container" style="
    padding-top: 1rem;">

        <div class="left">
            <div class="side-bar">
                
                <a href="#" class="item active">
                    <span><i class="fa-solid fa-bars"></i></span>
                    <h3>Menu</h3>
                </a>
                <a href="change_profile.php" class="item">
                    <span><i class="fa fa-user"></i></span>
                    <h3>Profile Settings</h3>
                </a>
                <a class="item" href="post.php">
                    <span><i style="font-weight:bold;"class="fa fa-upload"></i></span>
                    <h3>Create Post</h3>
                </a>
                <a href="feedback.php" class="item" >
                    <span><i class="fa fa-share"></i></span>
                    <h3>Leave Feedback</h3>
                </a>

                <a href="chat_setting.php" class="item">
                    <span><i style="color:#0f0;" class="fa fa-gear"></i></span>
                    <h3>Chat Settings</h3>
                </a>

                <a href="./delete.php" class="item">
                    <span><i style="color:red;"class="fa fa-cancel"></i></span>
                    <h3>Delete Account</h3>
                </a>

                <a class="item" href="#">
                    <span><i style="font-weight:bold;"class="fa-solid fa-arrow-up"></i></span>
                    <h3>Scroll to top</h3>
                </a>

                <a class="item" href="./includes/logout.inc.php">
                    <span><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                    <h3>Logout</h3>
                </a>
            </div>
        </div>
        
        <div class="users_activity">
            <div id="posts" class="main-content slide" >
                <!-- to be added php -->
            </div>
            <div id="followers" class="followers slide">
                <?php 
                    $followers = $friend->get_friends($user_id,"followers");
                    $following = $friend->get_friends($user_id,"following");
                    $follow_btn = "";
                    if(is_array($followers))
                    {
                        
                        foreach ($followers as $key ) {
                            $follow_btn ='unfollow';
                            $sql = "SELECT * FROM users WHERE user_id = '$key'";
                            $row = $DB->read($sql)[0];
                            include "single_follower.php";
                        }
                    }
                ?>
            </div>
            <div id="following" class="following slide">
            <?php 

                    $followers = $friend->get_friends($user_id,"following");
                    
                    if(is_array($followers))
                    {
                        foreach ($followers as $key ) {
                            if(in_array($key,$following))
                            {
                                $follow_btn = "Unfollow";
                            }else{
                                $follow_btn = "Follow";
                            }
                            $sql = "SELECT * FROM users WHERE user_id = '$key'";
                            [0];
                            if($row = $DB->read($sql)) $row = $row[0];
                            include "single_follower.php";
                        }
                    }
                ?>
            </div>
        </div>
        
    </main>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/profile.js"></script>
<script src="./javascript/follow_function.js"></script>
</html>