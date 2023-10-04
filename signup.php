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
        <h1 style="text-align:center;">Welcome to Kortana</h1>
        <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.5rem;">Please Signup !!</p>
        <!-- Individual loader -->
        <div class="individual-loader">
            <div class="spinner"></div>
        </div>        
        <form action="#" enctype="multipart/form-data" autocomplete="off">
            <!-- 
                FirstName,LastName, Username, Email/phoneNumber, Gender, Date Of Birth, password, Profile-pic
            -->
            <div class=" file">
                <img src="./images/user.jpeg" alt="">
                <div class="round">
                    <input type="file" name="image">
                    <i class="fa fa-camera">ca</i>
                </div>
            </div>
            <div class="error"></div>
            <div class="top-section">
                <input type="text" name="fname" placeholder="FirstName" autocomplete="off">
                <input type="text" name="lname" placeholder="LastName" autocomplete="off">
            </div>
            <div class="second-section">
                <div class="gender-section">
                    <section>
                        <input type="radio" name="gender" id="male" value="male">
                        <label for="male">Male</label>
                    </section>
                    <section>
                        <input type="radio" id="female"  name="gender" value="female">
                        <label for="female">Female</label>
                    </section>

                    
                </div>
                <div class="dob">
                    <input type="date" name="dob" id="dob" autocomplete="off">
                </div>
                
            </div>
            
            <input type="text" name="contact" placeholder="Email/ PhoneNumber" autocomplete="off">
            <input type="text" name="username" placeholder="Username" autocomplete="off">
            <input type="text" name="location" placeholder="Location e.g Lagos, Nigeria" autocomplete="off">
            
            <div class="top-section">
                <input type="password" name="pwd" placeholder="Password" autocomplete="off">
                <input type="password" name="repeatpwd" placeholder="Repeat Password" autocomplete="off">
            </div>
            <div class="submit">
                <input type="submit" name="submit" class="btn" value="Signup">
            </div>
            <div>
                <p style="display:inline">Already have an account ?</p>
                <a style="display:inline" href="login.php">Login</a> 
            </div>  
          
        </form>
    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/signup.inc.js"></script>
</html>