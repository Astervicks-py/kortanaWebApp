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
        
    </style>
</head>
<body>
    <div class="signup-card">
        <h1 style="text-align:center;">Welcome Back to Kortana</h1>
        <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.5rem;">Please Login !!</p>
        
        <form action="#" class="recover">
          
            <div class="error"></div>
   
            <input type="text" name="contact" placeholder="Email/ PhoneNumber">

            <div class="submit">
                <input type="submit" class="btn" value="VERIFY">
            </div>
            <div>
                <p style="display:inline">Back to login ?</p>
                <a style="display:inline" href="login.php">Login</a> 
            </div> 

          
        </form>

    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/login.inc.js"></script>
</html>