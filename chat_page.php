<?php
    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    session_start();
    if(isset($_GET['id'])){
        $incoming_id = $_GET['id'];
        $outgoing_id = $_SESSION['id'];
        $DB = new DB();
        $user = new User();
        // $chats = new Chat();
        // $result = $chats->read_chats($incoming_id,$outgoing_id);

        // echo "<pre>";
        // var_dump($result);
        // echo "<pre/>";

        // die();

        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$incoming_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            // var_dump($row);
        }
    }else{
        header('location:./chat_users_page.php');
        die();
    }
    include_once "header.php";
?>
<link rel="stylesheet" href="./custom_css/chat_page.css">
    <style>
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

        
        @media screen and (max-width: 992px){

            .friend .friend-name h5{
                font-size:.9rem;
                margin-right:5px !important;
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

    <?php include "./page_loader.php" ?>

    <nav style="background:var(--color-dark);color:var(--white);height:12vh;">
        <div class="container" style="grid-template-columns:1fr 1fr">
            <div class="back" >
                <a href="chat_users_page.php"><button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)"><i class="fa-solid fa-long-arrow-left"></i></button></a>
            </div>
            <div class="create" style="justify-self:flex-end">
                <div class="user" style="text-align:right">
                    <h5><?php echo $row['username'] ?><?php echo $row['verified'] ? "<span style='width:20px;height:20px;background:blue;color:#fff;display:flex;justify-content:center;align-items:center;text-align:center;font-size:.6rem;border-radius:50%'><i class='fa-solid fa-check'></i></span>": "" ?></h5>
                    <p><?php echo $row['status'] ?></p>
                    <!-- <p style="color:#0f0;font-family:cursive;transition:1s" class="typing"></p> -->
                </div>
                <a href="friends_profile_page.php?id=<?php echo $incoming_id ?>" class="profile-pic">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </a>
                <div class="setting" style="cursor:pointer">
                    <div class="hamburger-menu">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <?php 
                        $blocked = $user->user_data($outgoing_id)[0]['blocked'];
                        $blocked_btn = "block";
                        if(!is_null($blocked))
                        {
                            $blocked = json_decode($blocked,true);
                            if(is_array($blocked))
                            {
                                if(in_array($incoming_id,$blocked))
                                {
                                    $blocked_btn = "unblock";
                                }
                            }
                        }
                    ?>
                    <div class="dropdown-menu">
                        <div id="block" data-section="<?php echo $blocked_btn ?>" class="dropdown-item"><?php echo ucfirst($blocked_btn) ?> User</div>
                        <div id="unfollow" data-section="unfollow" class="dropdown-item">unfollow User</div>
                        <div id="report" data-section="report" class="dropdown-item">Report User</div>
                    </div>
                </div>
            </div>
            
        </div>
    </nav>
    <div class="individual-loader">
        <div class="spinner"></div>
    </div>        
    <form action="" id="operation_form">
        <input type="hidden" id="operation_input" name="operation">
        <input type="hidden" id="incoming_id" name="incoming_id" value="<?php echo $incoming_id ?>">
    </form>
    <div class="blackout"></div>
    <div class="info-box">
        <div class="warning" style="color:#fff"></div>
        <div class="btn-cont">
            <button id="confirm_operation" style="#000">Confirm</button>
            <button id="cancel">Cancel</button>
        </div>
    </div>
    <div class="container chat-container">
        <input type="hidden" class="friend_id" name="friend_id" value="<?php echo $_GET['id']?>">
        <div class="chat-users middle">
            <form action="#">
                <div class="search-bar">
                    <input type="search" id="chat_name" name="search" placeholder="Search for User">
                    <button>
                        <i class="fa fa-search"></i>
                    </button>
                    
                </div>
            </form>
            <div class="avaliable-users">
                <!-- -------- To be added by PHP----------  -->
            </div>
        </div>
        <div class="chat-area">
            <div class="chat-display">
                
            
                <!-- To be inserted by PHP -->
            
                
                
            </div>
            

            <div class="typing-area">
                <form action="#" enctype="multipart/form-data">

                    
                    <?php if(!is_blocked($outgoing_id,$incoming_id) && !am_blocked($outgoing_id,$incoming_id)){ ?>
                        <div class="file">
                            <input name="image" class="img" type="file" >
                            <button style="border-radius:10px 0 0 10px"><i class="fa fa-camera"></i></button>
                        </div>
                        <textarea id="chat_input" name="message" type="text" placeholder="Send a Message" autofocus autocomplete="off"></textarea>
                        
                        <!-- <button style="border-radius: 0 10px 10px 0; margin-right:10px;" ><i class="fa-solid fa-paperclip"></i></button>                 -->
                        
                        <button style="color:#fff;border-radius:0px 10px 10px 0px;"class="submit" type="submit" name="submit"><i class="fab fa-telegram-plane"></i></button>
                        
                    <?php }else{  ?>
                            <?php if(am_blocked($outgoing_id,$incoming_id)){ ?>
                                <div style="width:100%;text-align:center;color:#fff;">You can no longer send message this user</div>
                            <?php }else{ ?>
                                
                                <div onclick="unblock()" style="width:100%;text-align:center;color:#fff;">User is blocked.Tap to unblock User</div>
                            <?php } ?>
                    <?php } ?>
                    

                    <input type="hidden" name="incoming_id" value="<?php echo $incoming_id?>">
                    <input type="hidden" name="outgoing_id" value="<?php echo $outgoing_id?>">
                </form>
            </div>
        </div>
   
    </div>
    
</body>
<script src="./javascript/long-press.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/chat_page.js"></script>
</html>