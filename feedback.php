<?php require_once "profile_header.php" ?>
    <style>
        *{
            cursor:crosshair;
        }
        body{
            background: url('logo.jpg');
            background-position: center;
            background-size:cover;
            background-repeat:no-repeat;
            height:100vh;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
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
        <a href="./profile.php">
            <button>
                <i class="back fa fa-arrow-left-long"></i>
            </button>
        </a>
        
        <h2>Feedback <i class="fa fa-file-alt"></i></h2>
    </header>
    <div class="container">
        <form action="#">
            <h1 style="color:var(--color-white)">Leave feedback</h1>
            <input type="hidden" placeholder="Username" value="user_name">
            <textarea name="feedback" placeholder="What do you think of Kortana 😏"></textarea>
            
            <button type="submit" >Submit  <i class="fa fa-check"></i></button>
        </form>
    </div>
</body>

<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/feedback.js"></script>
</html>