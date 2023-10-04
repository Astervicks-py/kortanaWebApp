<?php 
require_once "profile_header.php";
$user_id = $_SESSION['id'];
$error = '';
$sql = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
if($result = mysqli_query($conn,$sql))
{
    $row = mysqli_fetch_assoc($result);
}


?>
    <link rel="stylesheet" href="custom_css/change_profile.css">
</head>
<body>
    <header>
        <a href="./profile.php">
            <button>
                <i class="back fa fa-arrow-left-long"></i>
            </button>
        </a>
        
        <h2>Profile Settings <i class="fa fa-edit"></i></h2>
    </header>
    <div class="container">
        <div class="id">
            <div class="profile" style="margin-bottom:10px;" >
                <img src="./includes/<?php echo $row['profile_pic']?>" alt="Profile Pic">
                
            </div>
            
            <div>
                <h3><?php echo $row['lname'] . " " . $row['fname']?></h3>
                <h3><?php echo $row['username']?></h3>
            </div>
        </div>
        <form action="#" style="position:relative" method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- <div class="error" style="color:red;background:#ccc;padding:10px;"><//?php echo $error ?></div> -->
            
            

            <div class="top-section">
                <div style="width:100%">
                    <label for="">First Name</label>
                    <input type="text" name="fname" placeholder="FirstName" value="<?php echo $row['fname'] ?>" autocomplete="off">
                </div>
                
                <div style="width:100%">
                    <label for="">Last Name</label>
                    <input type="text" name="lname" placeholder="LastName"  value="<?php echo $row['lname'] ?>" autocomplete="off">
                </div>
                
            </div>

            <div style="width:100%"><!-- value="<//?php echo $row['recovery_question']?>" -->
                <label>Recovery Question</label>
                <select name="recovery_question" id="" value="<?php echo $row['recovery_question']?>" >
                    <option>--PLEASE SELECT YOUR RECOVERY QUESTION--</option>
                    <option value="What is your Mother Madien name">What is your Mother Madien name</option>
                    <option value="What is your middle name">What is your middle name</option>
                    <option value="Who was your High School Crush">What is your High School Crush</option>
                    <option value="What is your Favourite Song">What is your Favourite Song</option>
                    <option value="What is the name of your Primary School">What is the name of your Primary School</option>
                </select>
            </div>
            <div style="width:100%">
                <label for="">Recovery Answer</label>
                <input type="text" name="recovery_answer" placeholder="Recovery Answer" value="<?php echo $row['recovery_answer']?>" >
            
            </div>
           
            <div class="top-section">
                <div style="width:100%">
                    <label for="">Username</label>
                    <input type="text" placeholder="Username" name="username" value="<?php echo $row['username'];?>" autocomplete="off">    
                </div>
                
                <div style="width:100%">
                    <label for="">Location</label>
                    <input type="text" name="location" placeholder="Location e.g Lagos, Nigeria"  value="<?php echo $row['location'] ?>" autocomplete="off">
                </div>
                
            </div>
            <div style="width:100%">
                <label for="">Bio</label>
                <textarea name="bio" placeholder="About Me"><?php echo $row['bio'];?></textarea>
            </div>
                
            <button type="submit" name="submit">Change  <i class="fa fa-check"></i></button>
        </form>
    </div>
</body>
<script src="./profile_page/js/change_profile.js"></script>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>

</html>