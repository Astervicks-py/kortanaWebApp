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
    <link rel="stylesheet" href="./custom_css/story.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.min.css">
    
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
                    <a href="<?php echo end($explode)?>">
                        <button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)">
                            <i class="fa-solid fa-long-arrow-left"></i>
                        </button>
                    </a>
                </div>

                <div class="memo">
                    <!-- <h1 style="text-align:center;">Update Your status</h1> -->
                    <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.3rem;" >Share your 2am inspiration 🙂 </p>
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
                    <a class="menu-item active">
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
            <div id="middle_1" class="middle">

                <form id="main_form" action="#" enctype="multipart/form-data">
                    <div class="error"></div>
                    <div class="post">
                        <input name="image" class="img" type="file">
                        <i class="fa fa-image icon"></i>
                    </div>
                    <input type="text" autofocus class="img_caption" placeholder="Image Caption" name="img_caption">
                    <img class="preview">
                    <textarea name="caption" type="text" placeholder="Caption"></textarea>
                    <input type="hidden" name="background" class="background_value">
                    <input type="hidden" name="color" class="color_value">
                    <input type="hidden" name="font" class="font_value">
                    <div class="submit">
                        <input type="submit" class="btn" value="Post">
                    </div>
                    
                
                </form>
                
                
               
            </div>
            <div class="middle"></div>
            <div id="middle_3" class="middle">
                <div class="division_2">
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Background</h5>
                        <div class="background">
                            <form class="custom-background" enctype="multipart/form-data">
                                <input type="file" id="new_background" class="custom" name="custom-background">
                                <i class="icon2 fa fa-plus"></i>
                            </form>
                            <?php 
                                $sql = "SELECT * FROM custom_background WHERE user_id = '$user_id'";
                                $result = $DB->read($sql);
                                if($result):
                                   foreach ($result as $key): ?>
                                        <img onclick="select(this)" src="./includes/<?php echo $key['background']?>">
                                   <?php endforeach?>
                                <?php endif ?>

                            <img onclick="select(this)" class="selected" src="./background/background_1.jpg">
                            <img onclick="select(this)" src="./background/background_2.jpg">
                            <img onclick="select(this)" src="./background/background_3.jpg">
                            <img onclick="select(this)" src="./background/background_4.jpg">
                            <img onclick="select(this)" src="./background/background_5.jpg">
                            <img onclick="select(this)" src="./background/background_6.jpg">
                            <img onclick="select(this)" src="./background/background_7.jpg">
                            <img onclick="select(this)" src="./background/background_8.jpg">
                            <img onclick="select(this)" src="./background/background_9.jpg">
                            <img onclick="select(this)" src="./background/background_10.jpg">
                            <img onclick="select(this)" src="./background/background_11.jpg">
                            <img onclick="select(this)" src="./background/background_12.jpg">
                            <img onclick="select(this)" src="./background/background_13.jpg">
                        </div>
                    </div>
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Text Color</h5>
                        <div class="text-color background">
                            <div onclick="color_select(this)" class="color selected" style="background:white;"></div>
                            <div onclick="color_select(this)" class="color" style="background:red;"></div>
                            <div onclick="color_select(this)" class="color" style="background:black;"></div>
                            <div onclick="color_select(this)" class="color" style="background:lime;"></div>
                            <div onclick="color_select(this)" class="color" style="background:yellow;"></div>
                            <div onclick="color_select(this)" class="color" style="background:blue;"></div>
                            <div onclick="color_select(this)" class="color" style="background:pink;"></div>
                            <div onclick="color_select(this)" class="color" style="background:orange;"></div>
                        </div>
                    </div>
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Font</h5>
                        <div class="font background">
                            <div onclick=" font_select(this) " style="font-family:Tahoma" class="font selected" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:logofont" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font2" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font3" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font4" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font5" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font6" class="font" >Aa</div>
                            <div onclick=" font_select(this) " style="font-family:font7" class="font" >Aa</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/story.js"></script>
<!-- <script src="./javascript/explore-users.js"></script> -->
</html>