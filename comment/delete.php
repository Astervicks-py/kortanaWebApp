<?php
	session_start();
	require_once "../includes/config.php";
	if(isset($_GET['id']))
	{
		$user_id = $_SESSION['id'];
		$post_id = $_GET['id'];

		$sql = "SELECT * FROM post LEFT JOIN users ON post.user_id = users.user_id WHERE post_id = '$post_id'";
		if($result = mysqli_query($conn,$sql))
		{
			$row = mysqli_fetch_assoc($result);
		}
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

</head>

<body class="<?php echo $row['theme'] ?>">
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
		<form action="#" method="POST" autocomplete="off">
			<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
			<button class="delete" style="font-size:1rem;background:red;color:#fff" type="submit" name="submit">Delete <i class="fa fa-remove"></i></button>
		</form>
	</div>
</body>
<script src="../fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./delete.js"></script>
</html>
