<?php
    session_start();
    require_once "./includes/config.php";
    require_once "./includes/classes.php";

    $DB = new DB();
    $notify = new Notify();
    if(isset($_SESSION['id'])){
        $sql = "SELECT * FROM users WHERE user_id = '{$_SESSION['id']}'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);
            $user_id = $_SESSION['id'];
            $prev = $_SERVER['HTTP_REFERER'];
            $explode = explode("/", explode("//",$prev)[1]);
        }
    }else{
        header('location:login.php');
        exit();
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
    <link rel="stylesheet" href="custom_css/post_page.css">
</head>
<style>
    .individual-loader
    {
        width:120px;
        height:120px;
        margin:auto;
        padding:15px;
        border-radius:15px;
        box-shadow: 0px 0px 10px 3px #000;
        position:absolute;
        top:50%;
        left:50%;
        transform:translateX(-50%) translateY(-50%);
        /* display:flex; */
        flex-direction:column;
        justify-content: center;
        align-items: center;
        z-index:3;
        background:#fff;
        gap:20px;
        opacity:.8;
        display:none;

    }

    .spinner
    {
        width:60px;
        height:60px;
        border:solid 15px #555;
        border-right:15px solid transparent;
        border-radius:50%;
        transition:1s;
        animation:spin 2s infinite ease-in-out
    }

    @keyframes spin{
        from{
            transform:rotate(0deg);
        }
        to{
            transform:rotate(360deg);
        }
    }
</style>
<body class="<?php echo $row['theme']?>">
    <nav>
        <div class="container" style="grid-template-columns:1fr">
            <div class="loged-user-info">
                <div class="back" >
                    <a href="<?php echo $explode[2]?>">
                        <button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)">
                            <i class="fa-solid fa-long-arrow-left"></i>
                        </button>
                    </a>
                </div>

                <div class="page-name">
                    <h3>Post</h3>
                </div>
                <div class="profile-pic" style="max-width:3.7rem;">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </div>
            </div>
            
        </div>
    </nav>
    
     <!-- Individual loader -->
     <div class="individual-loader">
        <div class="spinner"></div>
    </div>
    <main>
        <div class="container">
            <div class="left">
                <a class="profile" href="./profile.php" >
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>">
                    </div>
                    <div class="handle">
                        <h4 style="font-size:1.2rem;"><?php echo $row['fname'].' '.$row['lname'] ?></h4>
                        <p class="text-muted">
                            #<?php echo $row['username'] ?>
                        </p>
                    </div>
                </a>

                <!-- --------side bar----------- -->
                <div class="side-bar">
                    <a class="menu-item home-btn" href="index.php">
                        <span>
                            <i class="fa fa-home"></i>
                        </span>
                        <h3>Home</h3>
                    </a>
                    <a href="explore_page.php" class="menu-item ">
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
                            <?php 
                                $notification = $notify->get_notific($user_id);
                                $unread = [];
                                if(is_array($notification))
                                {
                                    foreach ($notification as $notific) {
                                        if($notific['status'] == 0)
                                        {
                                            $unread[] = $notific;
                                        }
                                    }
                                }
                                
                                $notification_count = count($unread);

                            ?>
                            <small class="notification-count"><?php echo $notification_count ?></small>
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
                    <a href= "chat_users_page.php" class="menu-item" id="messages-notification">
                        <span>
                            <i class="fa fa-envelope"></i>
                            <small class="notification-count" id="messages-count"></small>
                        </span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item active">
                        <span><i class="fa fa-upload"></i></span>
                        <h3>Create Post</h3>
                    </a>
                    <a class="menu-item" href="#">
                        <span><i style="font-weight:bold;"class="fa-solid fa-arrow-up"></i></span>
                        <h3>Back to top</h3>
                    </a>
                </div>
            </div>

            

            <div class="middle">

                <div class="memo">
                    <h1 style="text-align:center;"><?php echo strtoupper($row['username']); ?><br>Whats on your mind ?</h1>
                    <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.3rem;">Share with others !!</p>
                </div>
                
                <form action="#" enctype="multipart/form-data">
                    
                    <div class="error"></div>
                    <div class="post">
                        <input name="image" type="file">
                        <i class="fa fa-image icon"></i>
                    </div>
                    
                    <textarea name="caption" type="text" placeholder="Caption"></textarea>
                    <div class="submit">
                        <input type="submit" class="btn" value="Post">
                    </div>
                    
                
                </form>
               
            </div>

            <div class="middle"></div>
        </div>
    </main>

</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/post.inc.js"></script>
<!-- <script src="./javascript/explore-users.js"></script> -->
</html>