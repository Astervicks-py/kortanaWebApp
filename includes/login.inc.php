<?php

    require_once "config.php";
    require_once "classes.php";
    $generate = new Generate();

    // $token = $generate->random(20);
    // setcookie("token",$token);
    // setcookie("token","",time() - 3600);
    // var_dump($_COOKIE);
    // die();
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    
    /**Error Handlers */
    if(!empty($contact) && !empty($pwd)){

        /** Check if user has an account */
        $sql = "SELECT * FROM users WHERE contact = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"s",$contact);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $hashedpwd = $row['pwd'];
                /** Verify Password */
                if(password_verify($pwd,$hashedpwd)){

                    /** Update Online Status */
                    if(isset($_POST['remember']))
                    {
                        $token = $generate->random(20);
                        setcookie("token",$token);
                        $DB = new DB();
                        $sql = "UPDATE `users` SET `token` = '$token' WHERE user_id = '$row[user_id]'";
                        $DB->save($sql);
                    }
                    $status = 'online';
                    $sql = "UPDATE users SET status='{$status}' WHERE user_id = '{$row['user_id']}'";
                    mysqli_query($conn,$sql);
                    session_start();
                    $_SESSION['id'] = $row['user_id'];
                    echo "Matched";
                }else{
                    echo "Wrong Password";
                    die();
                }
            }else{
                echo "Invalid Login details";
                die();
            }
        }else{
            echo "Something Went wrong try again later.";
            die();
        }                      
    }else{
        echo "Empty Spaces Detected";
        die();
    }