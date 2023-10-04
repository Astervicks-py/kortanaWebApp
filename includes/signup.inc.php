<?php 
    require_once './config.php';
    require_once './classes.php';
    $generate = new Generate();
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $location = mysqli_real_escape_string($conn,$_POST['location']);
    $DB = new DB();
    if(isset($_POST['gender']) && $_POST['gender'] != "")
    {
        $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    }else{
        $gender = "";
    }
    
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    $repeatpwd = mysqli_real_escape_string($conn,$_POST['repeatpwd']);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);

    // echo date("Y");
    // echo $dob;

    /** Check For empty Spaces */
    if(!empty($location) && !empty($fname) && !empty($lname) &&  !empty($username) && !empty($contact) && !empty($pwd) && !empty($repeatpwd) && !empty($dob)){

        /** Check if a profile picture has been uploaded */
        if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
            /** Validate Email */
            if(filter_var($contact,FILTER_VALIDATE_EMAIL) || preg_match('/^[0-9]{11}$/',$contact)){

                /** Verify That Age is greater Than Thirteen */
                $explode = explode("-",$dob)[0];
                $age = (int)date("Y") - (int)$explode;
                if($age >= 16)
                {
                    /** Verify Password Length */
                    if(strlen($pwd) >= 8 ){
                        
                        /** Verify That pwd and repeatpwd are the same */
                        if($pwd === $repeatpwd){
                            
                            /**Check the file type of the image */
                            $extension = array('image/jpg','image/png','image/jpeg');
                            if(in_array(strtolower($_FILES['image']['type']),$extension)){
                                $status = "Online";

                                /** Hash Password */
                                $hashedpwd = password_hash($pwd,PASSWORD_DEFAULT);
                                
                                /** Checking if email exist in the database */
                                $sql = "SELECT * FROM users WHERE contact = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if(mysqli_stmt_prepare($stmt,$sql)){
                                    mysqli_stmt_bind_param($stmt,"s",$contact);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    if(mysqli_num_rows($result) < 1){
                                        
                                        /** Create Save Image in a images folder and save downloaded images */
                                        if(!is_dir("users-profile")){
                                            mkdir('users-profile');
                                        }
                                        
                                        $rand =  $generate->random(15,"mixed");
                                        $imageName = $_FILES['image']['name'];
                                        $imagePath = "users-profile/".$rand."_".$imageName;
                                        move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);
                                        
                                        /** Create a unique user id */
                                        $user_id = $generate->random(50,"mixed");
                                        /** Insert User Info Into Database
                                         *  
                                         * Starting Prepared Statement.
                                        */
                                        $sql = "INSERT INTO users(user_id,profile_pic,fname,lname,gender,DOB,username,location,contact,pwd) 
                                                VALUES(?,?,?,?,?,?,?,?,?,?)";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(mysqli_stmt_prepare($stmt,$sql)){
                                            mysqli_stmt_bind_param($stmt,"ssssssssss",$user_id,$imagePath,$fname,$lname,$gender,$dob,$username,$location,$contact,$hashedpwd);
                                            mysqli_stmt_execute($stmt);

                                            /** Insert user to h8is default chat setting the chat setting  */
                                            $chatsql = "INSERT INTO `chat_setting`(user_id) VALUE ('$user_id')";
                                            if($DB->save($chatsql))
                                            {
                                                /** Automatically Login in User After Signup */
                                                $sql2 = "SELECT * FROM users WHERE contact = ?";
                                                $stmt2 = mysqli_stmt_init($conn);
                                                if(mysqli_stmt_prepare($stmt2,$sql2)){
                                                    mysqli_stmt_bind_param($stmt2,"s",$contact);
                                                    mysqli_stmt_execute($stmt2);
                                                    $result = mysqli_stmt_get_result($stmt2);
                                                    if(mysqli_num_rows($result) >= 1){
                                                        $row = mysqli_fetch_assoc($result);
                                                        session_start();
                                                        $_SESSION['id'] = $row['user_id'];
                                                        //  !Imediately add the users to chat default setting to enable the chat setting default 
                                                        $SQL = "INSERT INTO `chat_setting` (`user_id`) VALUES('$_SESSION['id']')";
                                                        if($DB->save($SQL))
                                                        {
                                                            echo "Login Successful";
                                                        }else{
                                                            echo "Something Went Wrong. Try again later!";
                                                        }
                                                    }
                                                }
                                            
                                            }else{
                                                echo "Something went wrong try again later";
                                                die();
                                            }
                                        }else{
                                            echo "Something went wrong. Try Again Later";
                                            die();
                                        }
                                    }else{
                                        echo "The Contact Info already exist. Log into the account or use a different login info";
                                        die();
                                    }
                                }else{
                                    echo "Statement Failed. Try again later.";
                                    die();
                                }
                            }else{
                                echo "Profile Picture must be - jpeg jpg or png.";
                                die();
                            }
                        }else{
                            echo "Passwords dont match try again.";
                            die();
                        }
                    }else{
                        echo "Password must be atleast eight chracters.";
                        die();
                    }
                }else{
                    echo "User must be atleast 13 years";
                    die();
                }
            }else{
                echo "Not a Valid Email Nor Phone Number.";
                die();
            }
        }else{
            echo "Upload a profile picture by clicking the camera icon";
            die();   
        }
    }else{
        echo "empty String Detected.";
        die();
    }

