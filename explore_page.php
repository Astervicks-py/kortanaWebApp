<?php 
    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    session_start();
    $user_id = $_SESSION['id'];
    $friends = new Friends();
    $user_cls = new User();
    $user_cls = new User();
    $DB = new DB();

    /** get Followers and Following */
    $followers_ids = $friends->get_friends($user_id,"followers");
    $following_ids = $friends->get_friends($user_id,"following");

    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";

    if($result = mysqli_query($conn,$sql)){
        $row = mysqli_fetch_assoc($result);
    }
    include_once "includes/classes.php";
    $notify = new Notify();
    include_once "header.php";
    $prev = $_SERVER['HTTP_REFERER'];
    $explode = explode("/", explode("//",$prev)[1]);
    // echo "<pre style='color:#fff;'>";
    // var_dump($explode[2]);
    // echo "<pre/>";

?>
<style>
    main .container{
        grid-template-columns:20vw 1fr 1fr;
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
        background:var(--color-black);
        color:var(--color-text);
        padding:var(--card-padding);
        border-radius:10px;
    }
    header .name{
        text-align:right;
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
    .middle form{
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
    .middle form .search-bar
    {
        width:15%;
        /* margin:auto; */
        display:flex;
        align-items:center;
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

    .friends{
        width:100%;
        background:var(--color-dark);
        padding:var(--card-padding);
        border-radius:10px;
        display:flex;
        flex-direction:column;
        justify-content: flex-start;
        align-items:center;
        gap:1rem;
        border:solid 2px var(--color-border);
        /* overflow-y:scroll; */
    }
    

    .friends .friend{
        width:100%;
        padding:var(--card-padding);
        border:solid 1px var(--color-border);
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
        color:var(--color-text);
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

    /* .desiree
    {
        display:none;
    } */
    
    .loged-user-info
    {
        width:100%;
        display:flex;
        align-items:flex-start;
        justify-content: space-between;
        padding:0px 10px;
    }
    .item-cont
    {
        max-height:65vh;
        overflow-y:scroll;
        background:var(--color-black);
        border-radius:10px;
    }

    @media screen and (max-width: 992px){
        .side-bar .menu-item:nth-child(3)
        {
            display:flex;
        }

        .friend .friend-name h5{
            font-size:.9rem;
            margin-right:5px !important;
        }

        .middle:last-child
        {
            display:none;
        }

        main .container{
            grid-template-columns:30vw auto !important;
        }

        .left .menu-item h3{
            display:inline-block ;
        }
    
    }

    @media screen and (max-width: 600px){
        main .container{
            grid-template-columns:auto !important;
        }

        .item-cont
        {
            max-height:80vh;
        }

    }

    

</style>
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
                <div class="profile-pic" style="max-width:3.7rem;">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </div>
            </div>
            
        </div>
    </nav>
    <?php include "./page_loader.php" ?>
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
                    <a class="menu-item home-btn" href="index.php">
                        <span>
                            <i class="fa fa-home"></i>
                        </span>
                        <h3>Home</h3>
                    </a>
                    <a href="#" onclick="alert('This feature will be available in Kortana 1.0.0. Sorry 😥')"  class="menu-item">
                        <span>
                            <i class="fa fa-video-camera"></i>
                        </span>
                        <h3>Video</h3>
                    </a>
                    <a href="#" class="menu-item active">
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
                    <a class="menu-item" href="post.php">
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
                <form action="#">
                    <div style="font-size:1.2rem;font-weight:bold;width:100%;text-align:center;color:#fff">K-Family</div>
                    <div class="search-bar">
                        <input type="search" id="kfamilyBar" placeholder="Search for User">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                        
                    </div>
                </form>
                <div class="item-cont" >
                    <div class="friends k-family">
                        <!-- To be added By PHP -->
                    <?php 
                        $sql = "SELECT * FROM users WHERE NOT user_id = '$user_id'";
                        if($result = $DB->read($sql)){
                            foreach ($result as $row) {
                                include "single_friend.php";
                            }
                        }
                    ?>
                        
                    </div>
                </div>
            </div>

            <div class="middle">
                <form action="#">
                    <div style="font-size:1.2rem;font-weight:bold;width:100%;text-align:center;color:#fff">Desiree</div>
                    <div class="search-bar">
                        <input type="search" id="desireeBar" placeholder="Search for User">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                        
                    </div>
                </form>
                <div class="item-cont">
                    <div class="friends desiree followers">
                        <?php 
                        
                            /** Get Ids For Followers That are not followed back */ 
                            $desiree_ids = [];
                            foreach ($followers_ids as $id) {
                                if(!in_array($id,$following_ids))
                                {
                                    $desiree_ids[] = $id;
                                }
                            }

                            if(!empty($desiree_ids))
                            {
                                foreach ($desiree_ids as $user_id) {
                                    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
                                    $row = $DB->read($sql)[0];
                                    include "single_friend.php";
                                }
                            }else{
                                echo '
                                    <div class="friend" style="justify-content:center;">
                                        <div class="top" style="text-align:center;width:100%;display:block;font-size:3rem">
                                            No new Desiree 🤗
                                        </div>
                                        
                                    </div>
                                ';
                            }
                        
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>
    
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/explore-users.js"></script>
<script src="./javascript/follow_function.js"></script>
</html>