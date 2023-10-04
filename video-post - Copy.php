<?php
    session_start();
    require_once "./includes/config.php";

    if(isset($_SESSION['id'])){
        $sql = "SELECT * FROM users WHERE user_id = '{$_SESSION['id']}'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);
        }
    }else{
        header('location:login.php');
        exit();
    }

?>

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
        nav{
            width:100vw;
        }
        .post{
            width:100%;
            height:100px;
            margin:auto;
            /* padding:var(--card-padding); */
            border-radius:10px;
            background:var(--color-primary);
            display:flex;
            flex-direction: column;
            align-items:center;
            justify-content: center;
            position: relative;
            cursor:pointer;
        }
        .icon{
            font-size:3rem;
        }

        .post input[type='file']{
            width:150px;
            position:absolute;
            transform:scale(2.5);
            left:30%;
            opacity:0;
            cursor: pointer;
        }

        textarea{
            width:100%;
            font-size:1.3rem;
            color:#fff;
            background:var(--color-primary);
            outline:none;
            border-radius:12px;
            padding:var(--card-padding);
            resize: none;
        }

        textarea::placeholder{
            color:#fff;
            font-size:2rem;
            text-align: center;
        }
        textarea::-webkit-scrollbar
        {
            width:0;
        }
        /* .error
        {
            color:red;
            background:#000;
            border-radius:5px;
            width:80%;
            margin:auto;
            padding:5px 10px;
        } */

        .back
        {
            width:30px;
            height:30px;
            font-size:3rem;
            padding:10px;
            color:#000;
            background:#fff;
            border-radius10px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container" style="grid-template-columns:1fr 1fr 1fr;justify-content:space-between">
            <a  href="./video.php">
                <i class=" back fa fa-arrow-left-long"></i>
            </a>

            <div style="font-size:2rem;font-weight:bold" class="logo">
                @_<?php echo $row['username']?>
            </div>

                
            <div class="profile-pic" style="justify-self:flex-end">
                <img src="./includes/<?php echo $row['profile_pic'];?>">
            </div>
    
        </div>
    </nav>

    <div class="signup-card">
        <h1 style="text-align:center;"><?php echo strtoupper($row['username']); ?> - Whats on your mind</h1>
        <p style="text-align:center;margin-bottom:10px;font-family:cursive;font-size:1.5rem;">Share with others !!</p>
        
        <form action="#" enctype="multipart/form-data">
            
            <div class="error"></div>
            <div class="post">
                <input name="video" type="file">
                <i class="fa fa-video icon"></i>
            </div>
            
            <textarea name="caption" rows="1" type="text" placeholder="Caption"></textarea>
            <div class="submit">
                <input type="submit" class="btn" id="video-post-btn" value="Post">
            </div>
               
          
        </form>
    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script>
    const form = document.querySelector('form')
    const error = form.querySelector('.error')
    const videoBtn  = document.getElementById('video-post-btn');
    
    form.onsubmit = (e) =>
    {
        e.preventDefault();
    }

    videoBtn.onclick = () =>
    {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','./includes/video-post.inc.php',true);
        xhr.onload = () =>
        {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
            {
                let data = xhr.response;
                if(data == "success")
                {
                    location.href="./video.php";
                }else
                {
                    error.style.display ="block";
                    error.innerHTML = data;
                }
            }
        }
        let formInfo = new FormData(form);
        xhr.send(formInfo);
    }
</script>
</html>