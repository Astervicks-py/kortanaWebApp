<?php
    require_once "./includes/config.php";
    require_once "./includes/classes.php";

    $DB = new DB();
    $friends = new Friends();
    session_start();
    if(isset($_GET['id'])){
        $incoming_id = $_GET['id'];
        $outgoing_id = $_SESSION['id'];
        
        
        $sql = "SELECT * FROM group_chat LEFT JOIN groups ON group_id = '$incoming_id' RIGHT JOIN users ON users.user_id = group_chat.outgoing_id WHERE (incoming_id = '$incoming_id') ORDER BY group_chat.serial_no";

        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){

                if($row['read'] != NULL)
                {
                    $people_that_read = json_decode($row['read'],true);
                    if(!in_array($outgoing_id,$people_that_read)){
                        $people_that_read[] = $outgoing_id;
                        $new_read = json_encode($people_that_read);

                        $sql = "UPDATE group_chat SET `read` = '$new_read' WHERE incoming_id = '$row[incoming_id]'";
                        $DB->save($sql);
                    }
                }else{
                    $people_that_read[] = $outgoing_id;
                    $new_read = json_encode($people_that_read);

                    $sql = "UPDATE group_chat SET `read` = '$new_read' WHERE incoming_id = '$row[incoming_id]' ";
                    $DB->save($sql);

                }
            }
        }

        $sql = "SELECT * FROM groups WHERE group_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$incoming_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $group_row = mysqli_fetch_assoc($result);
            // var_dump($row);
        }
    }else{
        header('location:./chat_users_page.php');
        die();
    }

    $DB = new DB();
    $theme_sql = "SELECT theme FROM users WHERE user_id = '$_SESSION[id]'";
    $row = $DB->read($theme_sql)[0];
    
    include_once "header.php";
?>
<link rel="stylesheet" href="./custom_css/chat_page.css">
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

    nav .container .create .profile-pic
    {
        min-width:2rem;
    }
</style>
    <div class="loading-container">
        <div class="ring"></div>
        <span>Loading...</span>
    </div>

    <nav style="background:var(--color-white);color:var(--color-dark);height:10vh;">
        <div class="container" style="grid-template-columns:1fr 1fr">
            <div class="back">
                <a href="chat_users_page.php"><button style="cursor:pointer;font-size:1.1rem; padding:10px"><i class="fa-solid fa-long-arrow-left"></i></button></a>
            </div>
            <div class="create" style="justify-self:flex-end">
                <div class="user" style="text-align:right">
                    <h5><?php echo $group_row['group_name'] ?></h5>
                    <!-- <p><//?php echo $group_row['status'] ?></p> -->
                    <!-- <p style="color:#0f0;font-family:cursive;transition:1s" class="typing"></p> -->
                </div>
                <a  href="group_info_page.php?id=<?php echo $incoming_id ?>" class="profile-pic">
                    <img src="./includes/<?php echo $group_row['group_dp'] ?>">
                </a>
                <div class="setting" style="cursor:pointer">
                    <div class="hamburger-menu">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <div class="dropdown-menu">
                        <div id="exit" data-section="exit" class="dropdown-item">Exit Group</div>
                        <div id="report" data-section="report" class="dropdown-item">Report Group</div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </nav>
    <div class="individual-loader">
        <div class="spinner"></div>
    </div>        
    
    <div class="blackout"></div>
    <div class="info-box">
        <div class="warning" style="color:#fff"></div>
        <div class="btn-cont">
            <button style="#000">Confirm</button>
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
            <div class="avaliable-users available_groups">
                <!-- -------- To be added by PHP----------  -->
            </div>
        </div>
        <div class="chat-area">
            <?php 
                $sql = "SELECT * FROM chat_setting WHERE user_id = '$outgoing_id'";
                $chat_setting = $DB->read($sql)[0];
            ?>
            <div class="chat-display" style="background:url(<?php echo $chat_setting['background']?>)">
                
            
                <!-- To be inserted by PHP -->
            
                
                
            </div>
            
            
            <div class="typing-area">
                <form action="#" enctype="multipart/form-data">
                <?php 
                    $sql = "SELECT * FROM groups WHERE group_id = '$incoming_id'";
                    $group_info = $DB->read($sql)[0];
                    if($group_info['restricted'] == 1){
                        if($group_info['admin_id'] != $outgoing_id){ ?>
                            <div style="width:100%;text-align:center;color:#fff;">Only <a href="chat_page.php?id=<?php echo $group_info['admin_id'] ?>" style="color:#0f0"> Admin </a> can send message</div>
                            
                        <?php }else{ ?>
                    
                                <div class="file">
                                    <input onchange="hasChanged()" name="image" class="img" type="file" >
                                    <button style="border-radius:10px 0 0 10px"><i class="fa fa-camera"></i></button>
                                </div>
                                <textarea id="chat_input" name="message" type="text" placeholder="Send a Message" autofocus autocomplete="off"></textarea>

                                <button style="border-radius:0px 10px 10px 0px;"class="submit" type="submit" name="submit"><i style="color:#fff" class="fab fa-telegram-plane"></i></button>
                            <?php } ?>
                            
                        
                    <?php }else{ ?>
                        <div class="file">
                            <input name="image" class="img" type="file" >
                            <button style="border-radius:10px 0 0 10px"><i class="fa fa-camera"></i></button>
                        </div>
                        <textarea id="chat_input" name="message" type="text" placeholder="Send a Message" autofocus autocomplete="off"></textarea>

                        <button onclick="insertChat()" style="border-radius:0px 10px 10px 0px;"class="submit" type="submit" name="submit"><i style="color:#fff" class="fab fa-telegram-plane"></i></button>
                    <?php }?>
                
                    
                    <input type="hidden" name="incoming_id" value="<?php echo $incoming_id?>">
                    <input type="hidden" name="outgoing_id" value="<?php echo $outgoing_id?>">
                    
                    
                </form>
            </div>
        </div>
   
    </div>
    
</body>
<script src="./loader.js"></script>
<script src="./javascript/long-press.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/group-chat_page.js"></script>
<script>
    function $(element)
    {
        return document.querySelector(element);
    }
 
</script>
</html>