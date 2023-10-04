<?php 
    require_once "profile_header.php";
    require_once "includes/classes.php";
    $DB = new DB();
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
</head>
<style>
    main{
        top:0 !important;
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
        cursor:pointer;
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
        color:#fff;
        cursor:pointer;
    }

    h3
    {
        color:#fff;
    }

</style>
<body>
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
                    <h2><?php echo $row['lname'].' '.$row['fname']?></h2>
                    <p><?php echo ucfirst($row['gender'])?> <i class="fa fa-<?php echo $row['gender']?>"></i></p>
                </div>
                
                <div class="bio" style="margin-top:10px;">
                    <p><?php echo $row['bio']?></p>
                </div>
            </div>
        </header>
    </div>
    <div class="follow container">
        <a href="profile.php" class="stats" >
            <div>
                <span><?php echo $post_no ?></span>
            </div>
            <h3>Post</h3>
        </a>
        <div class="stats" style="border-bottom:solid 3px var(--color-border)">
            <div>
                <span><?php echo $row['followers'] ?></span>
            </div>
            <h3>Comrades </h3>
            
        </div>
        <a href="following_page.php" class="stats">
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

                <a id="kortney" class="item">
                    <span><i style="color:#0f0;" class="fa fa-robot"></i></span>
                    <h3>Chat with Kort</h3>
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
        
        <div class="main-content" >
            <!-- to be added php -->
        </div>
    </main>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/profile.js"></script>
</html>