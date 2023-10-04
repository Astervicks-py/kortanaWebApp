<?php require_once "profile_header.php" ?>
    <style>
        *{
            cursor:crosshair;
        }
        body{
            background: url('logo.jpg');
            background-position: center;
            background-size:cover;
            display:flex;
            flex-direction:column;
            /* justify-content:center; */
            align-items:center;
            font-family: Arial, Helvetica, sans-serif;
            cursor: auto;

        }
        .container{
            width:100vw;
            max-width:500px;
            height:max-content;
            border-radius:10px;
            margin-top:15vh;
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
        .action-btns button{
            padding:.6rem .4rem;
            width:60%;
            border-radius:10px;
            background:green;
            color:#fff;
            font-weight:bold;
            font-size:1.1rem;
            cursor:crosshair;
        }
        button:hover{
            background:var(--color-dark);
            color:var(--color-white);
            border:2px solid var(--color-white);
        }
        .action-btns > button{
            background:red;
        }
        .action-btns{
            width:100%;
            display:flex;
            justify-content: space-between;
            align-items:center;
            gap:10px;
        }
        .apology{
            padding:var(--card-padding);
            background:var(--color-white);
            color:#000;
            border-radius:5px;
        }
        .apology p{
            /* font-size:1.2rem; */
            font-family:sans-serif;
        }
        aside{
            font-style: italic;
            color:blue;
            text-align:right;
            font-weight:bold;
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
        
        <h2>Delete Request <i style="color:red;"class="fa fa-cancel"></i></h2>
    </header>
    <div class="container">
        <form action="#">
            <h1 style="color:var(--color-white)">Our Apology 😞</h1>
            <div class="apology">
                <p>
                    You are on this page probably because you were not satisfied with the Services we rendered or you were not well engaged on the site.<br/> &nbsp;&nbsp;&nbsp;We will like to tender our apology for wasting your time and any other issues you might have with us. Please Leave your reason for wanting to delete your account in the box below so that we can rectify it to maximize the satisfaction of other users and for you when you decided to signup to the site again. Or better still, deceit from deleting your account and lay your complain in the feedback so that it can be rectified immediately.Your satisfaction is our priority.
                    <br/> &nbsp;&nbsp;&nbsp; We apologize again for the inconviences we must have caused you.
                    <aside>Astervicks.js</aside>
                    <aside>CEO Kortana</aside>
                </p>
            </div>
            <div class="action-btns">
                <input type="hidden" placeholder="Username" value="user_name">
                <textarea style="width:100%" name="reason_for_delete" placeholder="Please give us your reason for requesting a delete 😥"></textarea>
            </div>
            
            <div class="action-btns">
                <button type="submit" style="width:100%" >
                    Delete  <i class="fa fa-x"></i>
                </button>
                <a href="./profile.php" style="text-decoration: none;width:100%" >
                    <button type="button" style="width:100%">
                        Cancel  <i class="fa fa-check"></i>
                    </button>
                </a>
            </div>
        </form>
    </div>
</body>

<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./profile_page/js/delete_account.js"></script>
</html>