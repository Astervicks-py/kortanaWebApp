<?php 
    session_start();
    include_once "classes.php";
    $post_id = $_POST['post_id'];
    $DB = new DB();
    $query = "SELECT * FROM likes WHERE post_id = '$post_id'";
    $result = $DB->read($query);
    $output = "";
    if(is_array($result))    
    {
        /** Convert the retrived likes back to array */
        $likes = json_decode($result[0]['likes'],true);
        
        /** Check if the user have liked */
        $user_ids = array_column($likes,"user_id");
        
        // var_dump($user_ids);
        if(count($user_ids) >= 1)
        {
            foreach ($user_ids as $user) {
           
                $query = "SELECT * FROM users WHERE user_id = '$user'";
                $row = $DB->read($query);

                // var_dump($row[0]);
                $output .= '
                    <div class="comment_content">
                        <div class="profile_pic">
                            <img src="../includes/'.$row[0]['profile_pic'].'">
                        </div>
                        <div class="user_comment">
                            <div class="user_name">'.$row[0]['username'].'</div>
                            <div class="user_name">'.$row[0]['lname'] .' '. $row[0]['fname'].'</div>
                        </div>
                    </div>
                ';
            }
            
        }else{
            $output = 
            '   
                <div class="nothing">
                    <h1>Only Kortana has Liked.<br/> Be the first to like 😊</h1>
                </div>
            ';
        }
        
        echo $output;
    }
    // var_dump($result);
?>