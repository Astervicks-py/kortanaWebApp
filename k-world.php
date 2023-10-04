<?php
    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    session_start();
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];

        
    }else{
        header('location:./index.php');
        die();
    }
    include_once "header.php";
?>
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


</style>
    <div class="loading-container">
        <div class="ring"></div>
        <span>Loading...</span>
    </div>

    <nav style="background:var(--color-dark);color:var(--white);height:10vh;">
        <div class="container" style="grid-template-columns:1fr 1fr">
            <div class="back" >
                <a href="home.php"><button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)"><i class="fa-solid fa-long-arrow-left"></i></button></a>
            </div>
            <div class="create" style="justify-self:flex-end">
                <div class="user" style="text-align:right">
                    <h5>K-Family</h5>
                    <p><?php echo "Three users are online"?></p>
                    <p style="color:#0f0;font-family:cursive;transition:1s" class="typing"></p>
                </div>
                <div class="profile-pic">
                    <img src=".\favicon.png">
                </div>
                
            </div>
            
        </div>
    </nav>

    <div class="container chat-container">
        <input type="hidden" class="friend_id" name="friend_id">
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
                    <div class="file">
                        <input name="image" class="img" type="file" >
                        <button style="border-radius:10px 0 0 10px"><i class="fa fa-camera"></i></button>
                    </div>
                    <textarea id="chat_input" name="message" type="text" placeholder="Send a Message" autofocus autocomplete="off"></textarea>
                    
                    <button style="border-radius: 0 10px 10px 0; margin-right:10px;" ><i class="fa-solid fa-paperclip"></i></button>                
                    
                    
                    <button class="submit" type="submit" name="submit"><i class="fab fa-telegram-plane"></i></button>
                </form>
            </div>
        </div>
   
    </div>
    
</body>
<script src="./loader.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/k-world.js"></script>
</html>