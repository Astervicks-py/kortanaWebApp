<?php

    require_once "config.php";
    require_once "classes.php";
    session_start();
    $DB = new DB();
    $user_id = $_SESSION['token'];
    $pwd = addslashes(mysqli_real_escape_string($conn,$_POST['pwd']));
    $repeat = addslashes(mysqli_real_escape_string($conn,$_POST['repeatpwd']));
    $answer = trim(strtolower(addslashes(mysqli_real_escape_string($conn,$_POST['recovery_answer']))));
    
    /**Error Handlers */
    if(!empty($pwd) && !empty($repeat) && !empty($answer)){
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $row = $DB->read($sql)[0];
        if($row['recovery_question'] != NULL && $row['recovery_answer'] != NULL)
        {
            if($answer == strtolower($row['recovery_answer']))
            {
                if(strlen($pwd) >= 8 )
                {
                    if($pwd != password_verify($row['pwd'], $pwd))
                    {
                        if($pwd == $repeat)
                        {
                            $hash = password_hash($pwd,PASSWORD_DEFAULT);   
                            /** Check if user has an account */
                            $status = 'online';
                            $sql = "UPDATE `users` SET pwd = '$hash', status = '$status' WHERE user_id = '$user_id' ";
                            $save = $DB->save($sql);
                            if($save)
                            {
                                // session_start();
                                $_SESSION['id'] = $row['user_id'];
                                echo "Matched";

                            }else
                            {
                                echo "Something Went Wrong";
                            }
                        }else
                        {
                            echo "Passwords Dont match";
                            die();
                        }
                    }else{
                        if($row['gender'] == "male")
                        {
                            $gender = "Sir";
                        }else{
                            $gender = "Madam";
                        }

                        echo "Hmmm, ".$gender." This is your Old password. Why dont you just use it to Login?? 😕";
                    }
                    
                }else
                {
                    echo "New Password should be 8 characters and above";
                    die();
                }
            }else
            {
                echo "Incorrect recovery Answer";
                die();
            }
        }else
        {
            echo "You did not include a recovery Question In your Profile";
            die();
        }              
    }else
    {
        echo "Empty Spaces Detected";
        die();
    }