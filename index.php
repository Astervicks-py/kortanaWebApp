<?php 

    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    $notify = new Notify();
    session_start();
    $no_comment = 0;
    $followers = [];
    $following = [];
    $DB = new DB();
    $friend = new Friends();
    $is_admin = false;
    // echo "<pre>";
    // var_dump( $_SERVER);
    // echo "</pre>";
    // die();
   if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);

            $friends = $friend->get_friends($user_id,"friends");
            $limit = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $page = $page >= 1 ? $page : 1;
            $offset = ($page - 1) * $limit;
        }

        /** Check that the stories are still within the time limit of 3 days */
        $sql = "SELECT * FROM stories";
        $duration_map = $DB->read($sql);

        if($duration_map)
        {
            $time = [];
            foreach ($duration_map as $key) {
                $detials['post_id'] = $key['post_id'];
                $detials['time'] = $key['time'];
                $time[] = $detials;
            }

            foreach ($time as $duration) {
                $post_id = $duration['post_id'];
                $when_posted = explode(" ",$duration['time'])[0];
                $STORY = new Story();
                $STORY->check_story($when_posted,$post_id);
            }
        }
        
        if($_SESSION['id'] == "ADMIN_KEY_8066086714")
        {
            $is_admin = true;

            if($_SERVER["HTTP_REFERER"] == "http://localhost/Kortana/login.php")
            {
                $generate = new Generate();
                $token = $generate->random(25);
                if($notify->insert_token_notification($user_id,$token))
                {
                    $sql = "UPDATE users SET token = '$token' WHERE user_id = '$_SESSION[id]'";
                    $DB->save($sql);
                }
            }

            
            
        }

    }else{
        header('location:./signup.php');
        die();
    }
    // echo "<pre>";
    // print_r( $_SERVER);
    // echo "<pre/>";
    // die();
   
    $return_to = "";
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $prev = $_SERVER['HTTP_REFERER'];
        $explode = explode("/", explode("//",$prev)[1]);
        $retun_to = end($explode);
    }

    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    
    // var_dump($explode);
    $get_post_sql = "SELECT * FROM post LEFT JOIN users ON users.user_id = post.user_id ORDER BY post.id DESC  LIMIT $limit OFFSET $offset";

    $get_post_result = $DB->read($get_post_sql);
    if(!is_array($get_post_result))
    {
        header("location:index.php?page=1");
        die();
    }
?>   
<?php include_once "header.php"; ?>

    <style>
        .intro
        {
            text-align:center;
            color:red;
            font-size:3rem;
            font-family:cursive;
            font-weight:bold;
            background:linear-gradient(to bottom,#50ff00,#0003ff,#ff0a00);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .friend_request{
            width:100%;
            display:flex;
            flex-direction:column;
            gap:1vh;
            border-radius:10px;
            padding-top:var(--card-padding);
            position: static;
            top:0;
        }
        .friend_request form{
            background:var(--color-black);
            border:solid 2px var(--color-border);
            padding:var(--card-padding);
            border-radius:10px;
            position:sticky;
            top:5rem;
            display:flex;
            width:100%;
            flex-direction:column;
            justify-content: center;
            align-items:center;
            
        }
        .friend_request form .search-bar
        {
            width:15%;
            /* margin:auto; */
            display:flex;
            align-items:center;
            transition:1s;
        }

        .friend_request form .search-bar:hover
        {
            width:100%;
        }

        .friend_request form .search-bar button
        {
            padding:10px;
            max-height:40px;
            font-size:1.3rem;
            border-radius:0 1rem 1rem 0;
        }
        .friend_request form input{
            width:100%;
            height:40px;
            border-radius:1rem 0 0 1rem;
            border:none;
            padding:0 15px;
        }

        .friends{
            width:100%;
            background:var(--color-black);
            border:solid 1px var(--color-border);
            padding:5px;
            border-radius:10px;
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            align-items:center;
            gap:1rem;
            /* overflow-y:scroll; */
        }
        

        .friends .friend{
            width:100%;
            border:solid 1px var(--color-border);
            padding:var(--card-padding);
            border-radius:10px;
            display: flex;
            gap:10px;
            flex-direction:column;
            background:var(--color-dark);
        }

        .friends .friend .top{
            width:100%;
            display:flex;
            gap:20px;
            color:white;
            font-size:1.2rem;
        }

        .friends .friend .top .profile_pic{
            width:45px;
            height:45px;
            border-radius:50%;
            object-fit:cover;
            object-position:center;
            
        }
        .friends .friend .bottom{
            width:100%;
            display:flex;
            justify-content: center;
            align-items:center;
            gap:10px;
        }
        .friends .friend .bottom button,.friends .friend .bottom a{
            width:100%;
            margin:auto;
            padding:10px;
            border-radius:20px;
            background:#0f0;
            color:#000;
            font-weight:bold;
            text-align:center;
        }

        @media screen and (max-width: 600px){
            .intro{
                /* font-size:2rem; */
            }
        }

        .story-btn
        {
            position:absolute;
            bottom:61px;
            left:50%;
            transform:translateX(-50%);
            background:#fff;
            color:#000;
            height:30px;
            width:30px;
            border-radius:50%;
            display:flex;
            justify-content: center;
            align-items:center;
            font-size:1.2rem;
        }

        .create small
        {
            position:absolute;
            background:#f00;
            color:#fff;
            border-radius:50%;
            font-size:1rem;
            right:0;
            top:0;
            width:17px;
            text-align:center;
            transform:translateY(-50%);
        }
        
    </style>
    <?php
        if(isset($explode[2])):
            if($explode[2] == "signup.php" || $explode[2] == "login.php" || $explode[2] == "new_password.php"):
             
                    $message = "";
                    $explode[2] == "signup.php" ? $message = "Lets Begin" : $message = "Welcome back";
                ?>
                    <?php include "./prime_loader.php" ?>
                    <audio src="./media/welcome.mp3" autoplay></audio>
            <?php else: ?>
                <?php include "./page_loader.php" ?>
            <?php endif?>

        <?php endif ?>
    
   
        
        <audio id="mySong" src="media/welcome.mp3" type="audio/mp3"></audio> 
        <audio id="mySong2" src="media/whistle.mp3" type="audio/mp3"></audio> 
    <nav style="box-shadow:0px 0px 10px var(--color-border)"> 
        <div class="container" >
            <div class="logo">
                <!-- <img src="./Kortana-logo-full.png">  -->
                <h1>K<span>ortana</span></h1>
            </div>
            
            <div class="create">
                <a class="nav-icon  notification_icon" href="#" onclick="alert('This feature is unavailable in this version of Kortana but will be in KORTANA 1.0.0 🤗')" style="width:50px;
                display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <i class="nav-icon fa fa-globe" style="color:#fff;font-size:1.5rem;"></i>
                    <!-- <p style="color:#fff">K-World</p> -->
                </a>
                <a class="nav-icon" style="position:relative" href="notification_page.php">
                    <i style="color:#fff;font-size:1.5rem;margin-right:5px;" class="nav-icon fa fa-bell"></i>
                    <small class="notific_count"></small>
                </a>
                <a class="nav-icon" style="position:relative" href="chat_users_page.php">
                    <i style="color:#fff;font-size:1.5rem;margin-right:5px;" class="nav-icon fa fa-envelope"></i>
                    <small class="messages-count"></small>
                </a>
                <a href="profile.php" style="border:2px solid var(--color-black)" class="profile-pic">
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
                <a href="profile.php" class="profile">
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>">
                    </div>
                    <div class="handle">
                        <h4 style="font-size:1.2rem;color:#fff;display:flex;gap:5px"><?php echo $row['fname'].' '.$row['lname'] ?><?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h4>
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
                    <?php if($is_admin): ?>
                        <a class="menu-item" href="ADMIN_PAGE.php">
                            <span><i style="font-weight:bold;"class="fa-solid fa-gears"></i></span>
                            <h3>My Admin</h3>
                        </a>
                    <?php endif ?>

                    <a href="#" onclick="alert('This feature will be available in Kortana 2.0.0. Sorry 😥')" class="menu-item">
                        <span>
                            <i class="fa fa-video-camera"></i>
                        </span>
                        <h3>Video</h3>
                    </a>

                    <a href="explore_page.php" class="menu-item">
                        <span>
                            <i class="fa-solid fa-people-roof"></i>
                        </span>
                        <h3>K-Family</h3>
                    </a>

                    <a class="menu-item desiree" href="desiree.php">
                        <span>
                            <i class="fa fa-user-friends"></i>
                        </span>
                        <h3>Desiree</h3>
                    </a>

                    <a class="menu-item" id="notifications">
                        <span>
                            <i class="fa fa-bell"></i>
                            
                            <small class="notification-count notific_count"></small>
                        </span>
                        <h3>Notification</h3>
                        <!---------- Notification Popup ---------------->
                        <div class="notification-popup" style="display:none;" >
                            <div class="notification-box" style="display:flex;
                            flex-direction:column">
                                
                                <!-- TO be added By php -->
                                
                            </div>
                            
                        </div>
                    </a>
                    
                    <a class="menu-item" id="messages-notification">
                        <span>
                            <i class="fa fa-envelope"></i>
                            <small class="notification-count messages-count"></small>
                        </span>
                        <h3>Messages</h3>
                    </a>

                    <a class="menu-item theme" id="theme">
                        <span><i class="fa fa-palette"></i></span>
                        <h3>Theme</h3>
                        <div class="theme-page">
                            <div class="theme-pick" style="background:#000" id="black"></div>
                            <div class="theme-pick" style="background:hsl(252,75%,64%)" id="dark"></div>
                            <div class="theme-pick" style="background:#ff0" id="yellow"></div>
                        </div>
                    </a>

                    <a class="menu-item" href="post.php">
                        <span><i style="font-weight:bold;"class="fa fa-upload"></i></span>
                        <h3>Create Post</h3>
                    </a>

                    <a class="menu-item" href="#">
                        <span><i style="font-weight:bold;"class="fa-solid fa-arrow-up"></i></span>
                    </a>
                </div>
                <a href="post.php" class="btn create-post btn-primary" >
                    Create Post
                </a>
            </div>

            <!-- ------------- Middle  --------------- -->
            <div class="middle">
                <!------------ Stories ------- -->
                <div class="stories">
                    <div class="story" style="background:url('./includes/<?php echo $row['profile_pic'] ?>')">
                        <div class="profile-pic">
                            <img src="./includes/<?php echo $row['profile_pic'] ?>" alt="">
                        </div>
                        <a class="story-btn" href="story_post.php">
                            <i class="fa fa-plus"></i>
                        </a>
                        <p class="name">Add to your Story</p>
                    </div>
                    <?php 
                        $personalStory = "SELECT * FROM stories INNER JOIN users ON stories.user_id = users.user_id WHERE stories.user_id = '$user_id'  ORDER BY stories.id DESC LIMIT 1";
                        $result = $DB->read($personalStory);
                        if($result):?>
                        <?php $rowData = $result[0] ?>
                            <a href="story_page.php?id=<?php echo $rowData['user_id'] ?>" class="story" style="background:url('<?php echo $rowData['background']?>')">
                                <div class="profile-pic">
                                    <img src="./images/profile-pics/channel-7.jpeg" alt="">
                                </div>
                                <p class="name">Your Story</p>
                            </a>
                    <?php endif?>
                    <?php
                        $haveStory = [];
                        $sql = "SELECT user_id FROM stories WHERE NOT user_id = '$user_id' ORDER BY id DESC";
                        $result = $DB->read($sql);
                        if($result)
                        {
                            foreach ($result as $user_id) {
                                if(!in_array($user_id,$haveStory))
                                {
                                    $haveStory[] = $user_id;
                                }
                            }
                            // var_dump($haveStory);
                        }

                        foreach ($haveStory as $user_with_story) {
                            $sql = "SELECT * FROM stories INNER JOIN users ON stories.user_id = users.user_id WHERE stories.user_id = '$user_with_story[user_id]'  ORDER BY stories.id DESC LIMIT 1";
                            $result = $DB->read($sql);
                            if($result)
                            {
                                $single = $result[0];
                                // var_dump($single);
                                include "single_story.php";
                            }
                        }
                        
                        
                    ?>
                </div>

                <!------------ End of Stories ------- -->

                <form class="create-post">
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>" alt="">
                    </div>
                    <input type="text" name="caption" style="border-bottom:solid 2px var(--color-border);color:#fff;" placeholder="what's on your mind" id="create-post">
                    <input type="submit" value="Post" class="post-btn btn btn-primary" style="border:solid 1px var(--color-border)">
                </form>

                <!-- ----------- FEEDS ----------- -->
                <div class="feeds" id="feeds">
                    <div class="test"></div>
                    <!--To be inserted in the php &/|| javaScript  -->
                    <?php
                    
                        foreach ($get_post_result as $row) {
                            include "single_post.php";
                        }
                    ?>
                </div>
                <br>
                <div class="navigator">
                    <?php if(isset($_GET['page']) && $_GET['page'] > 1):?>
                        <a href="index.php?page=<?php echo ($page - 1)?>" style="">
                            <button style=""><i class="fa fa-arrow-left"></i>Prev </button>
                        </a>
                    <?php endif; ?>
                    <?php
                        $nextPage = $page + 1;
                        $offset = ($nextPage - 1) * $limit;
                        $get_nextPage_sql = "SELECT * FROM post LEFT JOIN users ON users.user_id = post.user_id ORDER BY post.id DESC  LIMIT $limit OFFSET $offset";

                        $get_nextPage_result = $DB->read($get_nextPage_sql);
                        if(is_array($get_nextPage_result)): ?>
                            <a href="index.php?page=<?php echo ($page + 1)?>" style="">
                                <button style="">Next<i class="fa fa-arrow-right"></i></button>
                            </a>
                            <?php else: ?>
                            <a href="index.php?page=1" style="border:solid 2px var(--color-border)">
                                <button style="">Home</button>
                            </a>
                            
                        <?php endif ?>
                </div>
            </div>

            <!-- ------------- right Side  --------------- -->
            <div class="right">
                <!-- Messages -->
                <div class="messages" id="massages-tab" >
                    <h4 style="color:white"><b>Messages</b></h4>
                    <div class="head" style="margin-top:10px;">
                        <span style="color:white">New Messages</span>
                    </div>
                    
                    <div id="messages">
                        <!-- To be added in php -->
                    </div>
                </div>

                <!-- Friend Request -->
                <div class="friend_request">
                    <form action="#">
                        <div style="font-size:1.2rem;font-weight:bold;width:100%;color:#fff">Desiree</div>
                                                
                    </form>
                    <div class="item-cont">
                        <div class="friends desiree followers">
                            <!-- To be added By PHP -->
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </main>
 
    
</body>
<!-- <script src="./loader.js"></script> -->
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/home_page.js"></script>
<script src="./javascript/follow_function.js"></script>

</html>