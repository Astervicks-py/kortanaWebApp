<?php 
    require_once "config.php";
    session_start();
    $postid = $_POST['post_id'];
    $output = " ";
    if(isset($_SESSION['id']))
    {
        $sql = "SELECT * FROM comments LEFT JOIN users ON comments.user_id = users.user_id WHERE post_id = '$postid' ORDER BY comment_id DESC";
        if($result = mysqli_query($conn,$sql))
        {
            if(mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    // $sql = "SELECT * FROM "
                    $output .= 
                    '
                    <div class="comment_content">
                        <div class="profile_pic">
                            <img src="../includes/'.$row['profile_pic'].'">
                        </div>
                        <div class="user_comment">
                            <div class="user_name">'.$row['username'].'</div>
                            <div class="comment_details">'.$row['comment'].'</div>
                            <div class="date">'.$row['date'].'</div>
                        </div>
                    </div>
                    ';
                }
                
            }else{
                $output = 
                '   
                    <div class="nothing">
                        <h1>No comments yet.<br/> Be the first to comment 😊</h1>
                    </div>
                ';
            }
            echo $output;
        }
    }
?>