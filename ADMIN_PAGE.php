<?php 

    require_once "./includes/config.php";
    require_once "./includes/classes.php";
    session_start();
    $DB = new DB();
 

   if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        if($result = mysqli_query($conn,$sql)){
            $row = mysqli_fetch_assoc($result);

        }


    }else{
        header('location:./signup.php');
        die();
    }

    $return_to = "";
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $prev = $_SERVER['HTTP_REFERER'];
        $explode = explode("/", explode("//",$prev)[1]);
        $retun_to = end($explode);
    }

    if(isset($_POST['submit']))
    {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $idea = $_POST['idea'];
        $ln = $_POST['line'];
        $file = $_POST['filename'];
        $important = isset($_POST['important']) ? 1 : 0;
        if(!empty($title) && !empty($desc) && !empty($file) && !empty($important))
        {
            $sql = "INSERT INTO bug_report(title,description,idea,line,file_page,important) VALUES('$title','$desc','$idea','$ln','$file','$important')";
            $DB->save($sql);
        }


    }

?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="./css/admin.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.min.css">
    <link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
</head>

<body class="<?php echo $row['theme'] ?>">
        
    <?php include "./page_loader.php" ?>
    <nav style="box-shadow:0px 0px 10px var(--color-border)"> 
        <h1>Admin Page</h1>
    </nav>

    <!-- =================  Main Content ==================== -->
    <div class="individual-loader">
        <div class="spinner"></div>
    </div>
    <div class="op_error">Some Shit</div>
    <main>
        <!-- AUTHETICATION -->
        <div class="auth">
            <form method="POST" action="./includes/auth.inc.php" class="serial_code">
                <div class="error"></div>
                <input type="hidden" id="checker" name="localStoragePin">
                <div>
                    <label for="">DAILY PIN: </label>
                    <input type="text" name="pin" value="<?php echo isset($_GET['token']) ? $_GET['token'] : "" ?>">
                </div>
                <div>
                    <label for="">PERSONAL PASSWORD: </label>
                    <input type="text" name="password">
                </div>
                <div style="display:flex;gap:20px;">
                   <button id="auth-submit">Submit</button>
                    <a href="index.php"><button type="button">BACK</button></a> 
                </div>
                
            </form>
        </div>
        <div class="container" data-open="<?php echo $row['is_open']?>">
            <!-- ------------- Left Side  --------------- -->
            <!-- SIDEBAR START -->
            <?php include './ADMIN_SECTIONS/sidebar.php' ?>
            <!-- SIDE BAR END -->

            <!-- ------------- Middle  --------------- -->
            <div class="middle">

                <!-- STATS PAGE HERE -->
                <?php include "./ADMIN_SECTIONS/statsPage.php" ?>
                <!-- STATS PAGE END -->

                <div class="page feedbacks"></div>
                <div class="page reports"></div>

                <div class="page active bugReport">
                    <div class="page-title">
                        <h1>
                            KORTANA BUG REPORT
                        </h1>
                        
                    </div>
                    <div class="create-div">
                        <button onclick="changeBugView(this)" class="active" data-section="bugReportPage">
                            Reports
                        </button>
                        <button onclick="changeBugView(this)" data-section="addBugReport">
                            Add New Report
                        </button>
                    </div>
                    <div class="bugPage" id="bugReportPage">
                        <!-- BUGS STARTS HERE -->
                        <?php 
                            $sql = "SELECT * FROM bug_report WHERE fixed = '0' ORDER BY id DESC ";
                            if($bugs = $DB->read($sql))
                            {
                                if(count($bugs) > 0)
                                {
                                    foreach ($bugs as $bug) {
                                        include "./ADMIN_SECTIONS/singleBug.php" ;
                                    }
                                }
                            }

                            $sql = "SELECT * FROM bug_report WHERE fixed = '1' ORDER BY id DESC ";
                            if($bugs = $DB->read($sql))
                            {
                                if(count($bugs) > 0)
                                {
                                    foreach ($bugs as $bug) {
                                        include "./ADMIN_SECTIONS/singleBug.php" ;
                                    }
                                }
                            }
                        ?>
                        <!-- BUGS END HERE -->
                    </div>

                    <!-- ADD NEW BUG REPORT -->
                    <?php include "./ADMIN_SECTIONS/bugPage2.php" ?>
                    <!-- ADD NEW BUG REPORT END-->
                </div>
            </div>


        </div>
        
    </main>
 
    
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/ADMIN_PAGE.js"></script>

</html>