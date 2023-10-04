<?php 

require_once "profile_header.php";
    include_once "includes/classes.php";
    $DB = new DB();
    $friends = new Friends();
    $user_cls = new User();
    $friend = new Friends();
    $notify = new Notify();
    $id = $_SESSION['id'];
    
    if(isset($_GET['id']))
    {
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);

            $follow_btn = "Follow";
            $following_ids = $friends->get_friends($id,"following");
            // echo "<pre style='color:#fff'>";
            // print_r($following_ids);
            // echo "<pre/>";
            // die();
            $followers_ids = $friends->get_friends($id,"followers");

            if(in_array($user_id,$following_ids))
            {
                $follow_btn = "Unfollow";
            }
            elseif (in_array($user_id,$followers_ids) && !in_array($user_id,$following_ids)) {
                $follow_btn = "Follow Back";
            }

            if(isset($_SERVER['HTTP_REFERER']))
            {
                $prev = $_SERVER['HTTP_REFERER'];
                $explode = explode("/", explode("//",$prev)[1]);
                // echo end($explode);
                // die();
            }
            
            $query = "SELECT * FROM post WHERE user_id = '$user_id'";
            // var_dump($DB->read($query));/
            $ddt = $DB->read($query);
            if($ddt){
                $post_no = count($ddt);
            }else{
                $post_no = 0;
            }
            

        }else
        {
            header("location:profile.php");
            die();
        }
        
    }else
    {
        header("location:profile.php");
        die();
    }
    
    require_once "profile_header.php";                  
?>

<link rel="stylesheet" href="custom_css/profile.css">
</head>
<style>
    main{
        top:0;
    }
   .nav-bar button{
        padding:.7rem;
        border-radius:5px;
        font-size:1.2rem;
    }
    .nav-bar
    {
        width:100%;
        display:flex;
        justify-content: space-between;
        align-items:flex-start;
        padding:1rem;
        border-bottom:solid 1px #ccc;
    }
    button,input[type='submit']
    {
        cursior:pointer;
    }
    a
    {
        text-decoration:none;
    }
    body{
        cursor: auto;
        max-width:100vw;
    }
    .follow{
        margin:auto;
        font-family: arial;
        margin-top:5px;
        padding:0px 30px;
        padding-bottom:5px;
        display:flex;
        align-items: center;
        justify-content: space-between;
        color:#fff;
        width:100%;
        border-radius:5px;
        height:max-content;
        font-size:1.2rem;
        border-bottom:1px solid #ccc;
    }
    .bio
    {
        font-size:1rem;
        font-weight:100px;
        font-style:italic;
        font-family:emoji;
    }
    .name
    {
        color:#fff;
        font-family: arial;
    }

    .name div:first-child
    {
        display:flex;
        align-items:center;
        justify-content:center;
        gap:2rem;
    }

    .follow span{
        color:#0f0;
    }

    .follow .stats
    {
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }

    .follow-btn
    {
        font-size:1rem;
        padding:3px;
        border-radius:5px;
        font-weight:bold;
        background:yellow;
        border:solid 1px #000;
    }

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
                <div  class="profile">
                    <a href="fullscreen.php?section=profile&id=<?php echo $_GET['id']?>"><img src="./includes/<?php echo $row['profile_pic']?>" alt=""></a>
                </div>
            </div>
            <div class="header">
                <div>
                    <h2><?php echo $row['lname'].' '.$row['fname']?></h2>
                    <p><?php echo ucfirst($row['gender'])?> <i class="fa fa-<?php echo $row['gender']?>"></i></p>
                </div>
                <form action="#" method="POST" style="text-align:right">
                    <input type="hidden" name="friend_id" value="<?php echo $row['user_id']; ?>">
                    <button type="submit" class="follow-btn"><?php echo $follow_btn ?></button>
                </form>
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
    <main class="container">
        <div class="left">
            <div class="side-bar">
                <a href="#" class="item active">
                    <span><i class="fa-solid fa-bars"></i></span>
                    <h3>Menu</h3>
                </a>
                <a href="./index.php" class="item">
                    <span><i class="fa fa-home"></i></span>
                    <h3>Home</h3>
                </a>
                <a href="explore_page.php" class="item ">
                    <span>
                        <i class="fa-solid fa-people-roof"></i>
                    </span>
                    <h3>K-Family</h3>
                </a>
                <a class="item desiree" >
                    <span>
                        <i class="fa fa-user-friends"></i>
                    </span>
                    <h3>Desiree</h3>
                </a>
                <a class="item" id="notifications">
                    <span>
                        <i class="fa fa-bell"></i>
                        
                        <small class="notification-count"></small>
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
                <a href= "chat_users_page.php" class="item" id="messages-notification">
                    <span>
                        <i class="fa fa-envelope"></i>
                        <small class="notification-count" id="messages-count"></small>
                    </span>
                    <h3>Messages</h3>
                </a>
                <a href="feedback.php" class="item" >
                    <span><i class="fa fa-share"></i></span>
                    <h3>Report User</h3>
                </a>

                <a href="#" class="item">
                    <span><i class="fa-solid fa-arrow-up"></i></span>
                    <h3>Scroll to top</h3>
                </a>

                <a class="item" href="explore_page.php">
                    <span><i class="fa-solid fa-forward"></i></span>
                    <h3>Back to Explore</h3>
                </a>
            </div>
        </div>
        
        <div class="users_activity">
            <div id="posts" class="main-content feeds slide">
                <?php 
                    $sql = "SELECT * from post RIGHT JOIN users ON users.user_id = '$user_id' WHERE post.user_id = '$user_id'";
                    if($result = mysqli_query($conn,$sql)){
                        while($row = mysqli_fetch_assoc($result)){
                            $post_id = $row['post_id'];
                            $color = "#fff";
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
                                    border-radius:5px;font-size:1.4rem;
                                        background:var(--color-black);width:95%;margin:auto;padding:10px 7px">
                                            <p>
                                                
                                                '.$row['caption'].'
                                                
                                            </p>
                                    </div>
                
                                ';
                            }
                            
                            echo
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
            
                                    <div class="action-btns" style="padding:5px 7px">
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
                        
                    }
                
                ?>
            </div>
            <div id="followers" style="padding-top:1rem;" class="followers slide">
                <?php 
                    $followers = $friend->get_friends($user_id,"followers");
                    $following = $friend->get_friends($user_id,"following");
                    $myFollowers = $friends->get_friends($id,"followers");
                    $myFollowings = $friends->get_friends($id,"following");
                    if(is_array($followers))
                    {
                        $follow_btn = "";
                        foreach ($followers as $key ) {
                            if(in_array($key,$myFollowings))
                            {
                                $follow_btn = "Unfollow";
                            }else{
                                $follow_btn = "Follow";
                            }

                            $sql = "SELECT * FROM users WHERE user_id = '$key'";
                            $row = $DB->read($sql)[0];
                            // if($key != $id)
                            // {
                                include "single_follower.php";    
                            // }
                            
                        }
                    }
                ?>
            </div>
            <div id="following" style="padding-top:1rem;" class="following slide">
            <?php 

                    $following = $friend->get_friends($user_id,"following");
                    
                    if(is_array($following))
                    {
                        foreach ($following as $key ) {

                            $sql = "SELECT * FROM users WHERE user_id = '$key'";
                            $row = $DB->read($sql)[0];
                            if($key != $id)
                            {
                               include "single_follower.php"; 
                            }
                            
                        }
                    }
                ?>
            </div>
        </div>
        
    </main>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/friends_profile_page.js"></script>
<script src="./javascript/follow_function.js"></script>
</html>