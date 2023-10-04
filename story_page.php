<?php
require_once "includes/config.php";
require_once "includes/classes.php";

// echo "<pre>";
// print_r($_SERVER['REQUEST_URI']);
// echo "<pre/>";
// die();
session_start();
$user_id = $_SESSION['id'];
$user = new User();
$DB = new DB();
$time = new Time();

$row = $user->user_data($user_id)[0];

// echo "<pre style='color:#ff0'>";
// print_r($result);
// echo "</pre>";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = $page >= 1 ? $page : 1;

$limit = 1;
$offset = ($page - 1) * $limit;
if(isset($_GET['id']))
{
    $id = addslashes(mysqli_real_escape_string($DB->connect(),$_GET['id']));
  
    $sql = "SELECT * FROM stories LEFT JOIN users ON users.user_id = stories.user_id WHERE stories.user_id = '$id' ORDER BY stories.id DESC LIMIT $limit OFFSET $offset ";    
    
    $result = $DB->read($sql)[0];
    /** View The Users Post */
    
    if($result)
    {
        $row = $result;
        /** Add users details to viewers if its not logged user story */
        if($user_id != $_GET['id'])
        {
            $sql = "SELECT viewers FROM stories WHERE post_id = '$row[post_id]'";
            if($viewers = $DB->read($sql)[0])
            {
                if($viewers['viewers'] == NULL)
                {
                    $viewer_id[] = $user_id;
                    $viewers_string = json_encode($viewer_id);
                    $viewers_update_sql = "UPDATE stories SET viewers = '$viewers_string' WHERE post_id = '$row[post_id]'";
                    $DB->save($viewers_update_sql);

                    /** Increment Number of viewers in story */
                    $update = "UPDATE stories SET views = views + 1 WHERE post_id = '$row[post_id]'";
                    $DB->save($update);
                    
                }else{
                    $decode_viewers = json_decode($viewers['viewers'],true);
                    if(!in_array($user_id,$decode_viewers))
                    {
                        $decode_viewers[] = $user_id;
                        $viewers_string = json_encode($decode_viewers);
                        $viewers_update_sql = "UPDATE stories SET viewers = '$viewers_string' WHERE post_id = '$row[post_id]'";
                        $DB->save($viewers_update_sql);

                        /** Increment Number of viewers in story */
                        $update = "UPDATE stories SET views = views + 1 WHERE post_id = '$row[post_id]'";
                        $DB->save($update);
                    }
                    // var_dump($decode_viewers);
                    // die;
                }
            }
            
        }
        
    }else{
        header("location:story_page.php?id=$id&page=1");
    }



}else
{
    header("location:index.php");
    die;
}

$link = "index.php";

include_once "header.php";
?>
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
        position:absolute;
        z-index:3;
        background:#000;
        width:100%;
        max-width:800px;
        display:flex;
        justify-content: space-between;
        align-items:flex-start;
        padding:1rem;
        height:80px;
        border-bottom:solid 1px #ccc;
    }
    button,input[type='submit']
    {
        cursor:pointer;
    }

    .name{
        color:var(--color-border);
    }
    
    .post_wrapper
    {
        /* margin-top:70px; */
        width:100%;
        height:100%;
        display:flex;
        align-items:center;
        justify-content: center;
        font-size:2rem;
        background-size:cover !important;
        background-position:center !important;
        background-repeat:no-repeat !important;
        position:relative;
    }
    .viewers
    {
        width:max-content;
        height:max-content;
        gap:3px;
        flex-direction:column;
        position:absolute;
        bottom:0%;
        transform:translateY(-50%);
        z-index:3;
        padding:3px 15px;
        font-size:1.3rem;
        display:flex;
        justify-content: center;
        align-items:center;
        color:#fff;
        transition:1s;
        background:linear-gradient(transparent,#000);
    }


    .nav-btn
    {
        position:absolute;
        width:100%;
        display:flex;
        justify-content: space-between;
        bottom:10%;
        transform:translateY(-50%);
        height:50px;
    }
    .nav-btn button{
        font-size:2.5rem;
        padding:5px;
        opacity:0.2;
        background:#fff;
        color:#000;
        display:flex;
        justify-content: center;
        align-items:center;
    }

    .comment_content
    {
        width:100%;
        display:flex;
        align-items:center;
        gap:20px;
        background:#000;
        padding:10px;
        border-radius:10px;
        border:solid 1px var(--color-border);
    }

    .comment_content .user_name
    {
        color:#fff;
        font-weight:bold;
        font-size:1.2rem;
    }

    .comment_content 
    .comment_details
    {
        color:white;
        font-size:1.1rem;
    }
    .user_comment
    {
        width:100%;
    }
    .comment_content
    .date
    {
        color:var(--secondary);
        font-size:.9rem;
        font-family:cursive;
        float:right;
        font-weight:bold;
    }

    .viewed_users
    {
        position :absolute;
        bottom:0%;
        transform:translateY(100%);
        width:100%;
        max-height: 500px;
        min-height: 450px;
        display:flex;
        flex-direction: column;
        align-items: center;
        overflow-y: scroll;
        gap:10px;
        border:solid 2px var(--color-border);
        margin-top:1rem;
        border-radius:10px;
        background:var(--color-black);
        padding:1rem 0rem;
        transition:1s;
    }

    .active
    {
        bottom:85% !important;
    }
    
    .profile_pic
    {
        max-width:50px;
        max-height:50px;
        border-radius:50%;
        border:solid 3px red;
        overflow:hidden;
    }
    .profile_pic img
    {
        width:100%;
        max-width:50px;
        min-width:50px;
        max-height:50px;
        object-fit:cover;
        
    }
</style>

    <div class="container">
        <div class="nav-bar">
            <a href="<?php echo $link ?>"> <button><i class="fa fa-arrow-left-long"></i></button></a>
            <div class="name" style="display:flex;flex-direction:column;gap:5px;">
                <h1>#<?php echo $row['username'] ?></h1>
                <small style="text-align:right"><?php echo $time->timeago($row['time']) ?></small>
            </div> 
        </div>
        <?php
            $src = $row['profile_pic'];
        ?>

        <?php if($row['img'] == NULL):?>
        <div class="post_wrapper" style="background:url(<?php echo $row['background'] ?>);">
            <p style="text-align:center;color:<?php echo $row['text_color']?>;font-family:<?php echo $row['font']?>">
                <?php echo $row['caption'] ?>
            </p>
        <?php else: ?>
        <div class="post_wrapper">
            <img src="includes/<?php echo $row['img']?>" alt="">
            <div style="position:absolute;bottom:5%;background:linear-gradient(transparent,#000);width:90%;" class="img_caption_div">
                <p style="text-align:center;color:#fff;">
                    <?php echo $row['caption'] ?>
                </p>   
            </div>
              
        <?php endif ?>
        
            <?php if($user_id == $_GET['id']) : ?>
                    <div onclick="displayViewers()" class="viewers" onclick="displayViewers()"  >
                        <i class="fa fa-eye" ></i> <span><?php echo $row['views']?></span>
                    </div>
                    <div class="viewed_users">
                        <?php 
                            /** Get Viewers */
                            $sql = "SELECT * FROM stories WHERE post_id = '$row[post_id]'";
                            $result = $DB->read($sql)[0];
                            if($result != NULL):
                                $viewers_array_ids = json_decode($result['viewers'],true);
                                if($viewers_array_ids):

                                    foreach ($viewers_array_ids as $view_id): ?>
                                    <?php 
                                        $user = new User();
                                        $person = $user->user_data($view_id)[0];
                                    ?>
                                        <div class="comment_content">
                                            <div class="profile_pic">
                                                <img src="./includes/<?php echo $person['profile_pic']?>">
                                            </div>
                                            <div class="user_comment">
                                                <div class="user_name" ><?php echo $person['username'] ?></div>
                                                <small style="display:block;width:100%;font-size:.9rem;margin-left:auto;color:#0f0">12:23am</small>
                                            </div>
                                        </div>
                                    
                                    <?php endforeach ?>
                                <?php else: ?>
                                        <div style="color:#fff;display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        text-align:center">
                                            No views yet. 😃
                                            <br>
                                             But we are optimistic right?? 😏 
                                        </div>
                                <?php endif?>
                            <?php endif ?>

                        
                        
                        
                    </div>
            <?php endif ?>

            <div class="nav-btn">
                <a href="story_page.php?id=<?php echo $id?>&page=<?php echo ($page - 1)?>">
                    <button>
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                
                <a href="story_page.php?id=<?php echo $id?>&page=<?php echo ($page + 1)?>">
                    <button>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </a>

                
                
            </div>
        </div>
    </div>
</body>
<script src="./fontawesome-free-6.2.1-web/js/all.js"></script>
<script src="./javascript/story_page.js"></script>
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

