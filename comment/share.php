<?php
	session_start();
	require_once "../includes/config.php";
	require_once "../includes/classes.php";
	if(isset($_GET['id']))
	{
		$user_id = $_SESSION['id'];
		$post_id = $_GET['id'];
		$DB = new DB();
		$user = new User();

		$sql = "SELECT * FROM post LEFT JOIN users ON post.user_id = users.user_id WHERE post_id = '$post_id'";
        
		if($result = mysqli_query($conn,$sql))
		{
			$row = mysqli_fetch_assoc($result);
            // echo "<pre>";
            // print_r($row);
            // die();
            // echo "<pre/>";
		}

		$person = $user->user_data($user_id);

		
	}else
	{
		header("location:home.page");
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1.0,width=device-width">
	<title>Comment | Kortana</title>
	<link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">
	<link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/main.css">

</head>
<style>

    form
    {
        display:flex !important;
        flex-direction:column;
        gap:5px;
    }
    form textarea
    {
        width:90%;
        margin:auto;
        border-radius:10px;
    }
    .submit
    {
        width:90%;
        margin:auto;
        background:var(--color-dark);
        border:solid 2px var(--color-border) !important;
        font-size:2rem;
		padding:10px;
        color:#fff;
        background-color:transparent;
        border:none;

    }
    .liked
    {
        color:red;
    }
    .comment_content
    {
        border-radius:5px;
        padding:10px;
        height:60px;
        display:flex;
        color:#00f;
        align-items:center;
        gap:20px;
        background:#000;
    }
	form{
		display:block;
	}

</style>
<body class="<?php echo $person[0]['theme']?>">
	<div class="container">
		<nav style="width:100%;background:var(--secondary);">
			<div class="back" style="float:left">
				<a href="../index.php" style="float:left"><button style="cursor:pointer;font-size:2rem;padding:5px"><i class="fa-solid fa-long-arrow-left"></i></button></a>
			</div>
		</nav>
	</div>

	<div class="container">
		<!-- Inital Post -->
		<div class="post">
			<div class="header">
				<div class="profile_pic">
					<img src="../includes/<?php echo $row['profile_pic']; ?>">
				</div>
				<div>
					<h3><?php echo $row['username']; ?></h3>

				</div>
			</div>
			<div class="main">
				<?php if($row['img'] != NULL): ?>
					<img src="../includes/<?php echo $row['img']; ?>">
				<?php endif; ?>
			</div>
			<div class="caption">
				<?php echo $row['caption']; ?>
			</div>
            <form action="#" method="POST" autocomplete="off">
                <div class="error"></div>
                <input type="hidden" name="initial_id" value="<?php echo $row['user_id']?>"> 
                <input type="hidden" name="post_id" value="<?php echo $post_id ?>"> 
                <textarea name="share-caption" id="" placeholder="Change Caption" ></textarea>
                <button class="submit" style="">
                    <span>Repost &nbsp;</span><i class="fa fa-upload"></i><span></span>
                </button>
            </form>
		</div>
        
		
		
	</div>
</body>
<script src="../fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./share.js"></script>
</html>
