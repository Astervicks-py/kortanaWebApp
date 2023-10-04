<?php
    require_once "config.php";
    session_start();
    $userid = $_POST['user_id'];
    $postid = $_POST['post_id'];
    $comment = mysqli_real_escape_string($conn,$_POST['comment']);

    if(!empty($comment))
    {
        $sql = "INSERT INTO comments (user_id,post_id,comment) VALUES(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql))
        {
            mysqli_stmt_bind_param($stmt,"sss",$userid,$postid,$comment);
            mysqli_execute($stmt);
        }

    }else
    {
        echo "Empty";
    }
    
    // echo "<pre>";
    // echo $userid;
    // echo "<pre/>";
    // echo "<br/>";
    // echo $postid;


?>