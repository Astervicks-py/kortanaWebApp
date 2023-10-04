<?php 
    require_once "profile_header.php";
    session_start();
    if(isset($_SESSION['id'])){
        $outgoing_id = $_SESSION['id'];
        // require_once "./includes/create_table.php";
    }else{
        header('location:./login.php');
        die();
    }
?>
    <style>
        *{
            cursor:crosshair;
        }
        body{
            background: url('logo.jpg');
            background-position: center;
            background-size:cover;
            
            font-family: Arial, Helvetica, sans-serif;
            cursor: auto;

        }
        .container{
            width:80vw;
            max-width:500px;
            height:max-content;
            border-radius:10px;
            
            padding:var(--card-padding);
        }
        form{
            display:flex;
            flex-direction: column;
            justify-content: center;
            gap:1rem;
            align-items: center;
            font-family:monospace;
        }

        header{
            position:fixed;
            top:0;
            height:max-content !important;
            display:flex;
            align-items:center;
            gap:30px;
            justify-content: space-between;
            width:100vw;
            margin:auto;
            background-color: var(--color-primary);
            padding:var(--card-padding);
            padding-left:5vw;
            padding-right:5vw;
        }

        header button{
            background:var(--color-white) !important;
            font-size:3vw;
            padding:10px;
            border:none;
            cursor: crosshair;
            border-radius:5px;
        }

        header h2{
            font-size:25px;
            
        }

        input,textarea{
            width:100%;
            max-width:300px;
            height:30px;
            padding:10px;
            border-radius:5px;
            border:none;
            resize: none;
            position: relative;
        }
        textarea{
            height:100px;
            width:100%
        }
        button[type="submit"]{
            padding:.4rem;
            width:60%;
            border-radius:10px;
            background:green;
            color:#fff;
            font-weight:bold;
            font-size:1.1rem;
            cursor:crosshair;
        }
        button[type="submit"]:hover{
            background:var(--color-dark);
            color:var(--color-white);
            border:2px solid var(--color-white);
        }


    </style>
</head>
<body>
    <header>
        <a id="go-back">
            <button>
                <i class="back fa fa-arrow-left-long"></i>
            </button>
        </a>
        
        <h2>Chat With Kort  &nbsp;<i style="color:lime"class="fa fa-robot"></i></h2>
    </header>
    
    <div class="chat-area">
        <div class="chat-display">
            
            <!-- To be inserted by PHP -->
            

        </div>
        

        <div class="typing-area">
            <form action="#" enctype="multipart/form-data">
                
                <textarea name="message" type="text" placeholder="Send a Message" autocomplete="off"></textarea> 
                
                <button class="submit" type="submit" name="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </div>
    </div>
</body>

<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/chat-with-kort.js"></script>


</html>