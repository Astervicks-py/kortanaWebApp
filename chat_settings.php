<?php 
    require_once "profile_header.php";
    require_once "includes/classes.php";
    $DB = new DB();
    $user_id = $_SESSION['id'];
    $error = '';
    $sql = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
    if($result = mysqli_query($conn,$sql))
    {
        $row = mysqli_fetch_assoc($result);
    }

    $return_to = "";
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $prev = $_SERVER['HTTP_REFERER'];
        $explode = explode("/", explode("//",$prev)[1]);
        $retun_to = end($explode);
    }

?>
    <link rel="stylesheet" href="custom_css/chat_page_setting.css">
</head>
<body class="<?php echo $row['theme'] ?>">
    <nav>
        <div class="back">
            <a href="<?php echo $prev?>">
                <button style="cursor:pointer;font-size:1.6rem; padding:.4rem">
                    <i class="fa-solid fa-long-arrow-left"></i>
                </button>
            </a>
            <h2 style="color:#fff" >Profile Settings &nbsp;<i class="fa fa-edit"></i></h2>
        </div>
    </nav>

    <div class="container main-part">
        <form id="container-form"  action="#" style="position:relative" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php 
                $sql = "SELECT * FROM chat_setting WHERE user_id = '$user_id'";
                $chat_setting = $DB->read($sql)[0];
                // var_dump($chat_setting);
                // die;
            // die;    
            ?>
            
            <input type="hidden" id="background_image_value" name="background_image_value" value="<?php echo $chat_setting['background'] ?>">
            <input type="hidden" id="incoming_text_color_value" name="ITC" value="<?php echo $chat_setting['ITC']?>"> 
            <input type="hidden" id="outgoing_text_color_value" name="OTC" value="<?php echo $chat_setting['OTC'] ?>">
            <input type="hidden" id="incoming_background_color_value" name="IBC" value="<?php echo $chat_setting['IB'] ?>">
            <input type="hidden" id="outgoing_background_color_value" name="OBC" value="<?php echo $chat_setting['OB'] ?>">
            <input type="hidden" id="font_value" name="font_value" value="<?php echo $chat_setting['font'] ?>">

            <div class="preview_settings-container">
                <div class="error"></div>
                <section class="preview_screen" style="background:url(<?php echo $chat_setting['background']?>)">
                    <div class="incoming">
                        <div class="profile-pic">
                            <img style="width:50px;height:50px;object-fit:cover;object-position:center;" src="./favicon.png" alt="">
                        </div>
                        <div class="message" style="background:<?php echo $chat_setting['IB'] ?>">
                            <p class="message_content" style="color:<?php echo $chat_setting['ITC']?>;font-family:<?php echo $chat_setting['font']?>">Hey There <?php echo $row['username']?></p>
                            <p class="time" style="text-align:left;color:#00f;font-size:.6rem"><?php echo date("H:i:m")?></p>
                        </div>
                    </div>

                    <div class="outgoing" style="background:<?php echo $chat_setting['OB']?>">
                        <p class="message_content" style="color:<?php echo $chat_setting['OTC']?>;font-family:<?php echo $chat_setting['font']?>">Whats up person i don't Know 😏</p>
                        <div style="display:flex;justify-content:space-between;padding:0px 5px;">
                            <i style="float:left;color:#0f0" class="fa-solid fa-check-double"></i>
                            <div class="time" style="text-align:right;color:#00f;font-size:.6rem"><?php echo date("H:i:m")?></div>
                        </div>
                    </div>

                    <div class="typing-area">
                        <button class="typing-btn"><i class="fa fa-camera"></i></button>
                        <textarea class="sample-textarea" style="resize:none;width:80%;height:40px;"></textarea>
                        <button class="typing-btn"><i class="fab fa-telegram-plane"></i></button>
                    </div>
                </section>

                <section>
                    <div class="custom" style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Background</h5>
                        <div class="background">
                            <!-- <form action="" method="post" class="custom-background"enctype="multipart/form-data">
                                <input type="file" id="new_background" name="custom-background">
                                <i class="icon2 fa fa-plus"></i>
                            </form> -->
                            
                            <img onclick="select(this)" src="./background/background_14.jpg" class="selected">
                            <img onclick="select(this)" src="./background/background_1.jpg">
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

                    <!-- INCOMING BACKGROUND COLOR -->
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Incoming Background Color</h5>
                        <div class="text-color background">
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color selected" style="background:white;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:red;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:black;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:lime;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:yellow;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:blue;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:pink;"></div>
                            <div onclick="incoming_background_color_select(this)" class="incoming_background_color color" style="background:orange;"></div>
                        </div>
                    </div>

                    <!-- INCOMING MESSAGE BACKGROUND -->
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Incoming Text Color</h5>
                        <div class="text-color background">
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color selected" style="background:white;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:red;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:black;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:lime;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:yellow;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:blue;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:pink;"></div>
                            <div onclick="incoming_color_select(this)" class="incoming_text_color color" style="background:orange;"></div>
                        </div>
                    </div>

                    <!-- OUTGOING BACKGROUND COLOR -->
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Outgoing Background Color</h5>
                        <div class="text-color background">
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color selected" style="background:white;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:red;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:black;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:lime;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:yellow;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:blue;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:pink;"></div>
                            <div onclick="outgoing_background_color_select(this)" class="outgoing_background_color color" style="background:orange;"></div>
                        </div>
                    </div>                    

                    <!-- OUTGOING MESSAGE BACKGROUND -->
                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Outgoing Text Color</h5>
                        <div class="text-color background">
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color selected" style="background:white;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:red;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:black;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:lime;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:yellow;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:blue;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:pink;"></div>
                            <div onclick="outgoing_color_select(this)" class="outgoing_text_color color" style="background:orange;"></div>
                        </div>
                    </div>

                    <div style="max-height:max-content">
                        <h5 style="text-align:center;color:#fff;">Font</h5>
                        <div class="FONT background">
                            <div onclick=" font_select(this) " class="font selected" ><p style="font-family:Tahoma" >Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:logofont">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font2">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font3">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font4">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font5">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font6">Aa</p></div>
                            <div onclick=" font_select(this) " class="font" ><p class="font-option" style="font-family:font7">Aa</p></div>
                        </div>
                    </div> 
                </section>
            </div>
            <button type="submit" id="submitBtn" name="submit"> Change  <i class="fa fa-check"></i></button>
        </form>
    </div>
</body>
<script src="./javascript/chat_setting.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>

</html>