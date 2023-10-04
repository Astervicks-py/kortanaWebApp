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
		}

		$person = $user->user_data($user_id);
		$color = "#fff"; 
		$query = "SELECT likes FROM likes WHERE post_id = '$post_id' LIMIT 1";
		$RESULT = $DB->read($query);
		if(is_array($RESULT))    
		{
			/** Convert the retrived likes back to array */
			$likes = json_decode($RESULT[0]['likes'],true);
			/** Check if the user have liked */
			$user_ids = array_column($likes,"user_id");
			// echo "<pre>";
			// var_dump($user_ids);
			// die();
			// echo "</pre>";
			if(in_array($user_id,$user_ids))
			{
				$color= "red";
			}
		}

		// if(count($user_ids) >= 1 && in_array($user_id,$user_ids))
		// {
		// 	$class = "liked";
		// }
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
    .submit
    {
        width:max-content;
        font-size:50px;
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
			<?php 

				$sql2 = "SELECT * FROM comments WHERE post_id = '$post_id' ";
				if($data = mysqli_query($conn,$sql2))
				{
					$no_comment = mysqli_num_rows($data);
				}

			?>
            <form action="#" method="POST" autocomplete="off">
                <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                <!-- <button class="submit <?php echo $class ?>" style="">
                    <i class="fa fa-heart"></i> &nbsp;
					<span style="font-size:2rem"><//?php echo $row['likes'] ?></span>
                </button> -->
				<div class="interaction-btns">
					<a onclick="ajax_data(event,this)" style="font-size:1.5rem; color:<?php echo $color ?>;" href="./like.php?id=<?php echo $row['post_id'] ?>">
						<i class="fa fa-heart" ></i><span class="like-count"><?php echo $row['likes'] ?></span>
					</a>
					<a style="font-size:1.5rem; color:#fff;" href="./comment.php?id=<?php echo $row['post_id'] ?>">
						<i class="fa fa-comment" data-id="<?php echo $row['post_id'] ?>"></i><span><?php echo $no_comment ?></span>
					</a>
				</div>
            </form>
		</div>
        
		<div class="comment_container">
			<!-- To be added by PHP -->
			<br/>
            <div class="comment_content">
                <div class="profile_pic">
                    <img src="../favicon.png">
                </div>
                <div class="user_comment">
                    <div class="user_name">Kortana</div>
                    <div class="user_name">Astervicks</div>
                </div>
            </div>
		</div>
		
	</div>
</body>
<script src="../fontawesome-free-6.2.1-web/js/all.js"></script>

<script src="./like.js"></script>
</html>
