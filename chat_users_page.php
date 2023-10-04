<?php
    session_start();
    if(isset($_GET['id'])){
        unset($_GET['id']);
    }
    $user_id = $_SESSION['id'];
    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    $notify = new Notify();
    if(isset($_SESSION['id'])){
        $sql = "SELECT * FROM users WHERE user_id = ?";

        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            // var_dump($row);
            $prev = "index.php";
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $prev = explode("/", explode("//",$_SERVER['HTTP_REFERER'])[1])[2];
            }
            
        }
    }else{
        header('location:./login.php');
        die();
    }
    
    include_once "header.php";

?>
<!-- <link rel="stylesheet" href="./css/chat_users.css"> -->
<style>

    nav
    {
        box-shadow:0px 0px 10px var(--color-border);
    }
    main .container{
        grid-template-columns:25vw auto;
        margin-top:0;
    }
    .middle{
        width:100%;
        display:flex;
        flex-direction:column;
        gap:1vh;
        border-radius:10px;
        /* padding-top:var(--card-padding); */
        position: static;
        top:0;
    }
    .middle form{
        background:var(--color-black);
        padding:var(--card-padding);
        border-radius:10px;
        border:solid 2px var(--color-border);
        position:sticky;
        top:5rem;
        display:flex;
        width:100%;
        flex-direction:column;
        justify-content: center;
        align-items:center;
        
    }
    .middle form .search-bar
    {
        width:15%;
        /* margin:auto; */
        display:flex;
        align-items:center;
        justify-content: center;
        transition:1s;
    }

    .middle form .search-bar:hover
    {
        width:100%;
    }

    .middle form .search-bar button
    {
        padding:10px;
        max-height:40px;
        font-size:1.3rem;
        border-radius:0 1rem 1rem 0;
    }
    .middle form input{
        width:100%;
        height:40px;
        border-radius:1rem 0 0 1rem;
        border:none;
        padding:0 15px;
    }

    .loged-user-info
    {
        width:100%;
        display:flex;
        align-items:flex-start;
        justify-content: space-between;
        padding:0px 10px;
    }
    
    @media screen and (max-width: 992px){
        .side-bar .menu-item:nth-child(3)
        {
            display:flex;
        }

        .friend .friend-name h5{
            font-size:.7rem;
            margin-right:2px !important;
        }


        main .container{
            grid-template-columns:25vw auto !important;
        }

        .left .menu-item h3{
            display:inline-block ;
        }
    
    }

    .left .side-bar, .profile{
        width:100%;
        overflow:hidden;
    }

    @media screen and (max-width: 600px){
        main .container{
            grid-template-columns:auto !important;
        }

        .scroll-section-selector-cont
        {
            display:none;
        }

    }

    .section-selector,.scroll-section-selector
    {
        cursor:pointer;
    }

    /* Desiree */
    .friend{
        width:100%;
        padding:8px;
        border-radius:10px;
        display: flex;
        gap:10px;
        flex-direction:row;
        background:var(--color-dark);
        justify-content:space-between;
    }

    .friend .top{
        /* width:100%; */
        display:flex;
        gap:20px;
        color:var(--color-text);
        font-size:1.2rem;
    }

    .friend .top .profile_pic{
        width:45px;
        height:45px;
        border-radius:50%;
        object-fit:cover;
        object-position:center;
        
    }
    .friend .bottom{
        /* width:100%; */
        display:flex;
        justify-content: center;
        align-items:center;
        gap:10px;
    }

    .friend-name
    {
        width:max-content;
    }
    .friend .bottom button,.friend .bottom a{
        width:100%;
        margin:auto;
        padding:10px;
        border-radius:20px;
        background:#0f0;
        color:#000;
        font-weight:bold;
        text-align:center;
    }

    /* @media screen and (min-width: 992px){
        .friend
        {
            flex-direction:row;
        }

        .friend .top{
            font-size:.8rem;
        }
    } */
</style>
<?php include "./page_loader.php" ?>
    <audio id="mySong" src="media/welcome.mp3" type="audio/mp3"></audio> 
    <audio id="mySong2" src="media/whistle.mp3" type="audio/mp3"></audio> 
    <nav>
        <div class="container" style="grid-template-columns:1fr">
            <div class="loged-user-info">
                <div class="back" >
                    <a href="<?php echo $prev?>">
                        <button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)">
                            <i class="fa-solid fa-long-arrow-left"></i>
                        </button>
                    </a>
                </div>
                <div class="profile-pic" style="max-width:3.7rem;">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="left">
                <a class="profile" href="./profile.php" >
                    <div class="profile-pic">
                        <img src="./includes/<?php echo $row['profile_pic'] ?>">
                    </div>
                    <div class="handle">
                        <h4 style="font-size:1.2rem;color:#fff;"><?php echo $row['fname'].' '.$row['lname'] ?></h4>
                        <p class="text-muted">
                            #<?php echo $row['username'] ?>
                        </p>
                    </div>
                </a>

                <!-- --------side bar----------- -->
                <div class="side-bar">
                    <a href="index.php" class="menu-item home-btn">
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
                    <a href="desiree.php" class="menu-item desiree">
                        <span>
                            <i class="fa fa-user-friends"></i>
                        </span>
                        <h3>Desiree</h3>
                    </a>
                    <a class="menu-item" id="notifications">
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
                    <a class="menu-item active" id="messages-notification">
                        <span>
                            <i class="fa fa-envelope"></i>
                            <small class="notification-count" id="messages-count"></small>
                        </span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item" href="post.php">
                        <span><i style="font-weight:bold;"class="fa fa-upload"></i></span>
                        <h3>Create Post</h3>
                    </a>
                    <a class="menu-item" href="#">
                        <span><i style="font-weight:bold;"class="fa-solid fa-arrow-up"></i></span>
                        <h3>Back to top</h3>
                    </a>
                </div>
            </div>
            <div class="section-selector-cont">
                <div class="section-selector active-section" style="position:relative" data-section="chats" style="position:relative" onclick="activeSection(this)">
                    Chats
                    <span class="chat-notific" style="width:20px;color:#fff;
                    height:20px;display:flex;
                    background:#f00;justify-content:center;
                    font-size:.7rem;align-items:center;
                    position:absolute;border-radius:50%; 
                    top:0;right: 10px;transform:translate(20%, -20%);"></span>
                    </div>
                <div class="section-selector " data-section="groups" style="position:relative" onclick="activeSection(this)">
                    Group
                    <span class="group-notific" style="width:20px;color:#fff;
                    height:20px;display:flex;
                    background:#f00;justify-content:center;
                    font-size:.7rem;align-items:center;
                    position:absolute;border-radius:50%; 
                    top:0;right: 10px;transform:translate(20%, -20%);"></span>
                </div>
                <div class="section-selector" data-section="desiree" style="position:relative" onclick="activeSection(this)"> Desiree</div>
            </div>
            <div class="scroll-container" style="">
                <div class="scroll-section-selector-cont">
                    <div class="scroll-section-selector active-section" data-section="chats" style="position:relative" onclick="activeScrollSection(this)">
                        Chats
                        <span class="chat-notific" style="width:20px;color:#fff;
                        height:20px;display:flex;
                        background:#f00;justify-content:center;
                        font-size:.7rem;align-items:center;
                        position:absolute;border-radius:50%; 
                        top:0;right: 10px;transform:translate(20%, -20%);"></span>
                        </div>
                    <div class="scroll-section-selector" data-section="groups" style="position:relative" onclick="activeScrollSection(this)">
                        Group
                        <span class="group-notific" style="width:20px;color:#fff;
                        height:20px;display:flex;
                        background:#f00;justify-content:center;
                        font-size:.7rem;align-items:center;
                        position:absolute;border-radius:50%; 
                        top:0;right: 10px;transform:translate(20%, -20%);"></span>
                
                    </div>
                    <div class="scroll-section-selector" data-section="desiree" style="position:relative" onclick="activeScrollSection(this)"> Desiree</div>
                </div>
                <!-- --------------- chats section ------------------ -->
                <div id="chats-section" class="middle" style="width:100%">
                    <form action="#">
                        
                    <div style="font-size:1.2rem;font-weight:bold;width:100%;text-align:center;color:#fff" class="to-disappear">CHATS</div>
                        <div class="search-bar">
                            <input type="search" id="chat_name" name="search" placeholder="Search for User">
                            <button>
                                <i class="fa fa-search"></i>
                            </button>
                            
                        </div>
                    </form>
                    <div class="chat_users avaliable-users">
                        <!-- -------- To be added by PHP----------  -->
                    </div>
                </div>

                <!-- Groups Section  -->
                <div id="groups-section" class="middle" style="width:100%">
                    <form action="#">
                        <div style="font-size:1.2rem;font-weight:bold;width:100%;text-align:center;color:#fff" class="to-disappear">GROUPS</div>
                        <div class="search-bar">
                            <input type="search" id="chat_name" name="search" placeholder="Search for User">
                            <button>
                                <i class="fa fa-search"></i>
                            </button>
                            
                        </div>
                    </form>
                    <div class="available_groups avaliable-users">
                        
                        <!-- -------- To be added by PHP----------  -->
                    </div>
                </div>
            
                <!-- Desiree Section  -->
                <div id="desiree-section" class="middle" style="width:100%">
                    <form action="#">
                        <div style="font-size:1.2rem;font-weight:bold;width:100%;text-align:center;color:#fff" class="to-disappear">DESIREE</div>
                        <div class="search-bar">
                            <input type="search" id="chat_name" name="search" placeholder="Search for User">
                            <button>
                                <i class="fa fa-search"></i>
                            </button>
                            
                        </div>
                    </form>
                    <div class="available-desiree avaliable-users">
                        <!-- -------- To be added by PHP----------  -->
                    </div>
                </div>

            </div>
            
            
        </div>
    </main>
        
        
</body>
<!-- <script src="loader.js"></script> -->
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/chat_users_page.js"></script>
<script src="./javascript/follow_function.js"></script>
</html>