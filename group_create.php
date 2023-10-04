<?php
session_start();
include_once "./includes/classes.php";
$DB = new DB();
$friends = new Friends();
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$row = $DB->read($sql)[0];

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

        body
        {
            justify-content: flex-start;
            align-items:center;
            overflow-y:auto;
            height:max-content;
        }
        .signup-card{
            margin-top:10vh;
        }

        .comrades
        {
            width:100%;
            min-height:300px;
            max-height:60vh;
            overflow-y:scroll;
            display:flex;
            flex-direction:column;
            gap:5px;
            background:var(--color-white);
            border-radius:5px;
            padding:5px;
        }
        .single_comrade
        {
            background:var(--color-dark);
            width:100%;
            padding:10px;
            border-radius:10px;
            display:flex;
            justify-content:space-between;
            
        }
        img
        {
            width:40px;
            height:40px;
            border-radius:50%;
        }

        
        .loged-user-info{
            width:100%;
            display:grid;
            grid-template-columns: auto 1fr auto;
            align-items:center;
            justify-content:space-between;
            justify-items:center;
        }

        .loged-user-info h3{
            font-size:1.4rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container" style="grid-template-columns:1fr">
            <div class="loged-user-info">
                <div class="back" >
                    <a href="chat_users_page.php">
                        <button style="cursor:pointer;font-size:1.4rem; padding:var(--card-padding)">
                            <i class="fa-solid fa-long-arrow-left"></i>
                        </button>
                    </a>
                </div>

                <div class="page-name">
                    <h3>Create Group</h3>
                </div>
                <div class="profile-pic" style="max-width:3.7rem;">
                    <img src="./includes/<?php echo $row['profile_pic'] ?>">
                </div>
            </div>
            
        </div>
    </nav>
    
    <div class="signup-card">
        <div class="individual-loader">
            <div class="spinner"></div>
        </div>        
        <form action="#" enctype="multipart/form-data" autocomplete="off">
            <div class=" file">
                <img src="./images/user.jpeg" alt="">
                <div class="round">
                    <input type="file" name="image">
                    <i class="fa fa-camera">ca</i>
                </div>
            </div>
            <div class="error"></div>
            
            <input type="text" name="group_name" placeholder="Group Name" autocomplete="off">
            <input type="text" name="about_group" placeholder="About Group" autocomplete="off">
            <div style="display:flex;
            justify-content:space-between;
            width:100%">
                <label for="restriction">Only Admins can send messages <i style="color:#f00;
                font-weight:bold">This can be changed later</i></label>
                <input style="width:30px;
                        height:30px;"
                        type="checkbox" id="restriction">
            </div>
            
            <div style="width:100%;
            text-align:center;
            padding:10px;
            background:var(--color-dark);" >
                <h3>Add Participants</h3>
            </div>
            
            <div class="comrades" style="">
            <?php
                $friends_id = $friends->get_friends($user_id,"friends");
                foreach ($friends_id as $friend):
                    $sql = "SELECT * FROM users WHERE user_id = '$friend'";
                    $result = $DB->read($sql)[0];
            ?>
                <div class="single_comrade" style="">
                    <div style="display:flex;gap:15px;
                        align-items:center;">
                        <img style="" src="./includes/<?php echo $result['profile_pic']; ?>" alt="">
                        <h3><?php echo $result['username']; ?></h3>
                    </div>
                    <div>
                        <input style="width:20px;
                        height:30px;" type="checkbox" name="selected" data-userid="<?php echo $result['user_id']; ?>">
                    </div>
                </div> 
                
                <?php endforeach ?>
                
            </div>

            <input type="hidden" name="added_comrades" id="added">
            <input type="hidden" name="restriction" id="restrict">
            <div class="submit">
                <input type="submit" name="submit" class="btn" value="Create Group">
            </div>
          
        </form>
    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/create_group.js"></script>
</html>