<?php  
    require_once "includes/config.php";
    session_start();
    if(!isset($_SESSION['id'])){
        header('location:login.php');
        die();
    }

    $user_id = $_SESSION['id'];
    require_once "includes/classes.php";
    $DB = new DB();
    $user = new User();

    $row = $user->user_data($_SESSION['id'])[0];
    if(!isset($_GET['id']))
    {
        header("location:./login.php");
        die();
    }else
    {
        $group_id = $_GET['id'];
    }

    $sql = "SELECT * FROM groups WHERE group_id = '$group_id'";
    if($result = mysqli_query($conn,$sql)){
        $group_details = mysqli_fetch_assoc($result);
    }

    $sql = "SELECT img FROM group_chat WHERE incoming_id = '$group_id'";
    $image_names = [];
    if($images = $DB->read($sql))
    {
        // echo "<pre style='color:#fff;font-size:.8rem'>";
        // var_dump($images);
        // echo "<pre>";
        foreach ($images as $image_row) {
            // echo "<pre style='color:#fff;font-size:.8rem'>";
            // var_dump($image_row['img']);
            // echo "<pre>";
            if($image_row['img'] != NULL)
            {
                $image_names[] = $image_row['img'];
                
            }
        }
        // var_dump($image_names);
        // die();
        // $images = $images['img'];
        
    }


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="./css/profile.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.min.css">
    <link rel="stylesheet" href="custom_css/profile.css">
    <script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
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

    .img
    {
        width:100%;
        border:double 5px var(--color-border);
        margin-bottom:10px;
    }

    .img img
    {
        width:100%;
    }

    .be-fixed
    {
        position:fixed;
        top:0;
        left:50%;
        transform:translateX(-50%);
        z-index:9;
    }

    .follow
    {
        margin-top:275px;
    }

    @media screen and (max-width:600px)
    {
        .follow
        {
            margin-top:250px;
        }
    }
    @media screen and (min-width:600px)
    {
        .be-fixed
        {
            width:100%;
        }
    }

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

<body class="<?php echo $row['theme'] ?>"> 
    <div class="container be-fixed">
        <div class="nav-bar">
            <a href="group-chat_page.php?id=<?php echo $group_id ?>"> <button><i class="fa fa-arrow-left-long"></i></button></a>
            <div class="name">
                <h1>#<?php echo $group_details['group_name']?></h1>
            </div> 
        </div>
        <header>
            <div class="bottom-sect">
                <form class="profile">
                    <a href="fullscreen.php?section=profile&id=<?php echo $group_id ?>">
                        <img src="./includes/<?php echo $group_details['group_dp']?>" alt="">
                    </a>
                    
                    <div class="file">
                        <input id="file" type="file" name="profile">
                        <i class="fa fa-camera icons"></i>
                    </div>
                </form>
            </div>
            <div class="header">
                <div>
                    <h2><?php echo ucfirst( $group_details['group_name'] )?></h2>
                </div>
                
                <div class="bio" style="gap:10px;margin-top:10px; display:flex;justify-content:space-between;align-items:flex-end">
                    <p>
                        <?php 
                        if($group_details['slogan'] == NULL)
                        {
                            echo "No slogan available";
                        }else
                        {
                            echo $group_details['slogan'];
                        }
                        ?>
                    </p>
                <?php if(is_admin($user_id,$group_id)):?>
                    <div id="edit_btn" >
                        <i style="font-size:1.2rem" class="fa fa-pen"></i>
                    </div>
                <?php endif ?>
                </div>
            </div>
        </header>
    </div>
    <div class="follow container">
        <a href="#posts" onclick="movePrimary(this)" class="stats" style="border-bottom:solid 3px var(--color-border)">
            <div>
                <span><?php 
                if(is_array($image_names))
                {
                    echo count($image_names);
                }?></span>
            </div>
            <h3>Post</h3>
        </a>
        <a href="#followers" onclick="movePrimary(this)" class="stats">
            <div>
                <?php 
                    $members = $group_details['members'];
                    $members = json_decode($members,true);
                    $count = count($members);
                ?>
                <span><?php echo $count ?></span>
            </div>
            <h3>Members </h3>
        </a>
    </div>
    <div class="individual-loader">
        <div class="spinner"></div>
    </div>  
    <div class="blackout"></div>
    <form id="info_box" class="info-box">
        <div>
            <textarea resize="none" type="text" name="slogan_edit"></textarea>
        </div>
        <input type="hidden" id="operation_input" name="operation">
        <input type="hidden" name="group_id" value="<?php echo $_GET['id'] ?>">
        <div class="btn-cont">
            <button id="confirm_operation" style="#000">Change</button>
            <button id="cancel">Cancel</button>
        </div>
    </form>
    <input type="hidden" id="incoming_id" value="<?php echo $group_id ?>" >
    <main class="container" style="margin-bottom:200px;padding-top: 1rem;">

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
                <?php foreach ($image_names as $img): ?>
                    <div class="img">
                        <img src="./includes/<?php echo $img ?>" alt="">
                    </div>  
                <?php endforeach ?>
            </div>

            <div id="followers" class="followers slide">
                <?php 
                    $friends = new Friends();
                    $following = $friends->get_friends($user_id,"following");
                    $followers = $friends->get_friends($user_id,"followers");
                    $members = $group_details['members'];
                    $members = json_decode($members,true);
                    // $key = array_keys($members,$user_id);
                    // unset($members[$key[0]]);
                    foreach ($members as $member) {
                        $row = $user->user_data($member)[0];
                        if(!is_admin($user_id,$group_id))
                        {
                            if(in_array($member,$followers) && !in_array($member,$following))
                            {
                                $follow_btn = "Follow Back";
                            }elseif(in_array($member, $followers)) {
                                $follow_btn = "Unfollow";
                            }else
                            {
                                $follow_btn = "Follow";
                            }
                        }else{
                            $follow_btn = "Remove";
                        }

                       
                        
                        /** Changing the follow btn */
                        
                        include "./single_member.php";
                    }
                ?>
            </div>
        </div>
        
    </main>
    
    <script src="./profile_page/js/group_info_page.js"></script>
</body>
</html>