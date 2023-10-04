<?php 
session_start();
require_once "includes/classes.php";
require_once "./includes/config.php";
    $notify = new Notify();
    $user_id = $_SESSION['id'];
    $no_comment = 0;
    $followers = [];
    $following = [];
    $DB = new DB();
    $friend = new Friends();

   if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);
        }

       
        

    }else{
        header('location:./signup.php');
        die();
    }
?>

<?php include_once "header.php"?>
<style>
    nav
    {
        box-shadow:0px 0px 10px var(--color-border);
    }
    .loged-user-info .page-name
    {
        color:#fff;
        display:flex;
        justify-content: center;
        align-items:center;
        font-size:1.5rem;
    }
    main .container{
        width:70%;
        gap:1rem;
        grid-template-columns:20vw 1fr;
    }
    .header{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    header button{
        padding:.7rem;
        border-radius:5px;
        font-size:1.2rem;
    }
    header{
        width:100%;
        background:var(--color-primary);
        color:var(--color-dark);
        padding:var(--card-padding);
        border-radius:10px;
    }
    header .name{
        text-align:right;
    }
    .loged-user-info
    {
        width:100%;
        display:flex;
        align-items:center;
        justify-content: space-between;
        padding:0px 10px;
    }
    .middle{
        width:100%;
        display:flex;
        flex-direction:column;
        gap:1vh;
        border-radius:10px;
        padding-top:var(--card-padding);
        position: static;
        top:0;
    }
    .notification-box
    {
        display:flex;
        flex-direction:column;
        max-height:95vh;
        overflow-y:scroll;
        padding:10px;
        gap:1rem;

    }

    .notific
    {
        padding:5px;
        align-items:center;
    }
    .notification-body
    {
        display:flex;
        flex-direction:column;
    }

    .profile_pic img, .profile_pic
    {
        min-width:70px !important;
        max-width:70px !important;
        border-radius:center;

    }
    
    @media screen and (max-width: 600px){
       .container
       {
        width:100% !important;
       }

    }

</style>
    <audio id="mySong" src="media/welcome.mp3" type="audio/mp3"></audio> 
    <audio id="mySong2" src="media/whistle.mp3" type="audio/mp3"></audio>
    <nav>
        <div class="container" style="grid-template-columns:1fr">
            <div class="loged-user-info">
                <div class="back" >
                    <a class="back-icon" href="./index.php">
                        <button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)">
                            <i class="fa-solid fa-long-arrow-left"></i>
                        </button>
                    </a>
                </div>

                <div class="page-name">
                    <h3>Notifications</h3>
                </div>
                
                <div class="profile-pic" style="max-width:3.7rem;">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </div>
            </div>
            
        </div>
    </nav>
    <main>
        <div class="container">
            <!-- ------------- Left Side  --------------- -->
            <div class="left">
                <a href="profile.php" class="profile">
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>">
                    </div>
                    <div class="handle">
                        <h4 style="font-size:1.2rem;color:#fff;"><?php echo $row['fname'].' '.$row['lname'] ?></h4>
                        <p class="text-muted">
                        @_<?php echo $row['username'] ?>
                        </p>
                    </div>
                </a>

                <!-- --------side bar----------- -->
                <div class="side-bar">
                    <a href="home.php" class="menu-item">
                        <span><i class="fa fa-home"></i></span><h3>Home</h3>
                    </a>

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

                    <a class="menu-item active">
                        <span>
                            <i class="fa fa-bell"></i>
                            
                            <small class="notification-count"></small>
                        </span>
                        <h3>Notification</h3>
                    </a>

                    <a class="menu-item" id="messages-notification">
                        <span>
                            <i class="fa fa-envelope"></i>
                            <small class="notification-count" id="messages-count"></small>
                        </span>
                        <h3>Messages</h3>
                    </a>

                    <a class="menu-item theme" id="theme">
                        <span><i class="fa fa-palette"></i></span>
                        <h3>Theme</h3>
                        <div class="theme-page">
                            <div class="theme-pick" style="background:#000" id="black"></div>
                            <div class="theme-pick" style="background:hsl(252,75%,64%)" id="dark"></div>
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

            <!-- -------------- Middle Side ------------- -->
            <div class="middle">
                <div class="notification-box"></div>
            </div>
        </div>
    </main>
</body>
<script src="./loader.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/notification.js"></script>

</html>