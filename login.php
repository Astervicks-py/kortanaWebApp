<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kortana</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.min.css">

    <style>
        body{
            width:100vw;
            background-image: url(./images/ASTERVICKS\ PERFECT\ LOGO.jpg);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height:100vh;
            overflow: hidden;
            display:flex;
            flex-direction:column;
            justify-content: center;
            align-items:center;
            
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
</head>
<body>
    <div class="signup-card">
        <h1 style="text-align:center;">Welcome Back to Kortana</h1>
        <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.5rem;">Please Login !!</p>

        
        <div class="individual-loader">
            <div class="spinner"></div>
        </div>        
        
        <form action="#">
            <!-- 
                FirstName,LastName, Username, Email/phoneNumber, Gender, Date Of Birth,password, Profile-pic
            -->
            <div class="error">Add a profile picture</div>
            
            <input type="text" name="contact" placeholder="Email/ PhoneNumber">
            
            <input type="password" name="pwd" placeholder="Password">

            <div style="width:100%;display:flex;gap:10px;align-items:center">
                <input style="width:15px;height:15px;" type="checkbox" name="remember" id="remember"> 
                <label style="padding-top:3px;" for="remember">Remember me on this device</label>
            </div>
            
            
            <div class="submit">
                <input type="submit" class="btn" value="Login">
            </div>
            <div>
                <p style="display:inline">Dont Have an account ?</p>
                <a style="display:inline" href="signup.php">Signup</a> 
            </div> 
            <div>
                <p style="display:inline">Forgot Password?</p>
                <a style="display:inline" href="forgotpassword.php">Recover</a> 
            </div> 
          
        </form>

    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/login.inc.js"></script>
</html>