<?php
require_once "includes/config.php";
require_once "includes/classes.php";

session_start();
$user_id = $_SESSION['id'];
$user = new User();
$DB = new DB();

$row = $user->user_data($user_id)[0];

// echo "<pre style='color:#ff0'>";
// print_r($result);
// echo "</pre>";

if(isset($_GET['id']))
{
    $id = addslashes(mysqli_real_escape_string($DB->connect(),$_GET['id']));
    if($_GET['section'] == "profile")
    {
        $sql = "SELECT username,profile_pic FROM users WHERE user_id = '$id'";    
    }
    else if($_GET['section'] == "post")
    {
        $sql = "SELECT * FROM post LEFT JOIN users ON users.user_id = post.user_id WHERE post_id = '$id'";    
    }
    else if($_GET['section'] == "chat")
    {
        $sql = "SELECT * FROM chats LEFT JOIN users ON users.user_id = chats.outgoing_id WHERE chats.msg_id = '$id'";
        $result = $DB->read($sql)[0];
        $filename = $result['img'];
        $filepath = "./includes/" . $filename;
    }
    $result = $DB->read($sql)[0];
}

$prev = $_SERVER['HTTP_REFERER'];
$explode = explode("/", explode("//",$prev)[1]);
include_once "header.php";


?>
<script>

    <?php 

        if($_GET['section'] == "chat"):
    ?>
        window.onload = () =>{
            window.location.href = "download.php?file=<?php echo $filename ?>";
        }
    <?php endif; ?>

</script>
<style>
    .container{
        width:100vw;
        height:100vh;
        max-width:800px;
        overflow:hidden;
    }

    img{
        width:100%;
        height:100vh;
        object-fit:contain;
        object-position:center;
    }
    .nav-bar button{
        padding:.7rem;
        border-radius:5px;
        font-size:1.2rem;
    }
    .nav-bar
    {
        position:fixed;
        width:100%;
        max-width:800px;
        display:flex;
        justify-content: space-between;
        align-items:flex-start;
        padding:1rem;
        border-bottom:solid 1px #ccc;
    }
    button,input[type='submit']
    {
        cursor:pointer;
    }

    .name{
        color:var(--color-border);
    }
</style>

    <div class="container">
        <div class="nav-bar">
            <a href="<?php echo $explode[2] ?>"> <button><i class="fa fa-arrow-left-long"></i></button></a>
            <div class="name">
                <//?php if($_GET['section'] == "profile")( $name = $result["username"])
                    if($_GET['section'] == "post")
                
                ?>
                
                <h1>#<?php echo $result['username'] ?></h1>
            </div> 
        </div>
        <?php
            if($_GET['section'] == "profile")
            {
                $src = $result['profile_pic'];
            }
            else
            {
                $src = $result['img'];   
            }   
        ?>
        <img src="./includes/<?php echo $src ?>" alt="">
    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>

<script>
    function $(element) {
        return document.querySelector(element);
    }

    if($("body").classList.contains("dark"))
    {
        $(":root").style.setProperty('--color-dark','hsl(252, 30%, 17%)');
        $(":root").style.setProperty('--color-black','hsl(252,30%,10%)');
        $(":root").style.setProperty('--color-border','var(--color-primary)');
        $(":root").style.setProperty('--color-white','hsl(252,75%,64%)');
    }else{
        $(":root").style.setProperty('--color-dark','#000');
        $(":root").style.setProperty('--color-black','#000');
        $(":root").style.setProperty('--color-border','#0f0');
        $(":root").style.setProperty('--color-white','#000');
    }
</script>
</html>

