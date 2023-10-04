<?php

include_once "config.php";
session_start();
$user_id = $_SESSION['id'];
$video = $_FILES['video'];
$caption = mysqli_real_escape_string($conn,$_POST['caption']);
$likes = 1;
// var_dump($video);

if($video['name'] !="" || !empty($caption))
{
    /** Check Video Format */
    if($video['type'] == "video/mp4")
    {
        /** Create a folder for video if doesnt exist */
        if(!is_dir('video_post'))
        {
            mkdir('video_post');
        }

        /** Generate Unique Video Path */
        $time = time();
        $video_name = $video['name'];
        $video_path = 'video_post/'.$time.'_'.$video_name;
        
        /** Download the video into to folder */
        move_uploaded_file($video['tmp_name'],$video_path);

        /** Insert videopath into post table first */
        $sql = "INSERT INTO post (user_id,img,caption,likes) VALUES(?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql))
        {
            mysqli_stmt_bind_param($stmt,"issi",$user_id,$video_path,$caption,$likes);
            if(mysqli_stmt_execute($stmt))
            {

                /** Insert Video_post table next */
                $sql = "INSERT INTO video_posts (user_id,video,caption,likes) VALUES(?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt,$sql))
                {
                    mysqli_stmt_bind_param($stmt,"issi",$user_id,$video_path,$caption,$likes);
                    if(mysqli_stmt_execute($stmt)){
                        $likes_table_name = 'likes_'.$time.'_'.$video_name;
                        $comment_table_name = 'comment_'.$time.'_'.$video_name;

                        $sql1 = "CREATE TABLE `{$likes_table_name}` (
                            user_id INT(11) ZEROFILL  NOT NULL,
                            likes INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL
                        )";

                        if(mysqli_query($conn,$sql1))
                        {
                            $sql2 = "CREATE TABLE `{$comment_table_name}` (
                                comment_id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                                user_id INT(11) NOT NULL,
                                comment VARCHAR(255) NOT NULL
                            )";

                            if(mysqli_query($conn,$sql2))
                            {
                                echo "success";
                            }
                        }
                        

                    }
                }
            }else
            {
                echo " Something went wrong please try again later";
            }
        }else
        {
            echo " Something went wrong please try again later";
        }
    }else
    {
        echo "Not Supported File format";
    }
}else
{
    echo "All space cannot be empty";
}
