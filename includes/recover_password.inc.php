<?php
    // echo "Recovry Begin";
    // die();

    require_once "config.php";
    require_once "classes.php";

    $contact = addslashes(mysqli_real_escape_string($conn,$_POST['contact']));
    
    /**Error Handlers */
    if(!empty($contact)){

        /** Check if user has an account */
        $sql = "SELECT * FROM users WHERE contact = '$contact' ";
        $DB = new DB();
        $result = $DB->read($sql);
        if($result)
        {
            session_start();
            $_SESSION['token'] = $result[0]['user_id'];
            echo "Matched";
        }else
        {
            echo "NO ACCOUT MATCHED";
        }
    //     if(mysqli_stmt_prepare($stmt,$sql)){
    //         mysqli_stmt_bind_param($stmt,"s",$contact);
    //         mysqli_stmt_execute($stmt);
    //         $result = mysqli_stmt_get_result($stmt);

    //         if(mysqli_num_rows($result) > 0){
    //             $row = mysqli_fetch_assoc($result);
    //             $hashedpwd = $row['pwd'];
    //             /** Verify Password */
    //             if(password_verify($pwd,$hashedpwd)){

    //                 /** Update Online Status */
    //                 $status = 'online';
    //                 $sql = "UPDATE users SET status='{$status}' WHERE user_id = '{$row['user_id']}'";
    //                 mysqli_query($conn,$sql);
    //                 session_start();
    //                 $_SESSION['id'] = $row['user_id'];
    //                 echo "Matched";
    //             }else{
    //                 echo "Wrong Password";
    //                 die();
    //             }
    //         }else{
    //             echo "Invalid Login details";
    //             die();
    //         }
    //     }else{
    //         echo "Something Went wrong try again later.";
    //         die();
    //     }                      
    // }else{
    //     echo "Empty Spaces Detected";
    //     die();
    }