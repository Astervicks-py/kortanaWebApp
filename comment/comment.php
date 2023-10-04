<?php
	session_start();
	require_once "../includes/config.php";
	require_once "../includes/classes.php";
	if(isset($_GET['id']))
	{
		$user_id = $_SESSION['id'];
		$post_id = $_GET['id'];

		$sql = "SELECT * FROM post LEFT JOIN users ON post.user_id = users.user_id WHERE post_id = '$post_id'";
		if($result = mysqli_query($conn,$sql))
		{
			$row = mysqli_fetch_assoc($result);
			$DB = new DB();
			$user = new User();
			$person = $user->user_data($user_id);
		}
	}else
	{
		die();
		header("location:home.page");
	}
	$prev = "./index.php";
	if(isset($_SERVER['HTTP_REFERER'])) 
	{
		$link = $_SERVER['HTTP_REFERER'];
		$prev = explode("/", explode("//",$link)[1]);
		$back = $prev[2]."/". end($prev);
		// echo $back;
		// die();
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
<body class="<?php echo $person[0]['theme']?>">
	<div class="container">
		<nav style="width:100%;background:var(--secondary);">
			<div class="back" style="float:left">
				<a href="../index.php" style="float:left"><button style="cursor:pointer;font-size:2rem;padding:5px"><i class="fa-solid fa-long-arrow-left"></i></button></a>
			</div>
		</nav>
	</div>

	<div class="container ">
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
		</div>
		<div class="comment_container">
			<!-- To be added by PHP -->
		</div>
		<form action="#" method="POST" autocomplete="off">
			<textarea autofocus="on" name="comment" rows="1" placeholder="Leave a Comment"></textarea>
			<input type="hidden" name="user_id" value="<?php echo $user_id?>">
			<input type="hidden" name="post_id" value="<?php echo $post_id?>">
			<button class="submit" style="font-size:4rem" type="submit" name="submit"><i class="fab fa-telegram-plane"></i></button>
		</form>
	</div>
</body>
<script src="../fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./comment.js"></script>
</html>
