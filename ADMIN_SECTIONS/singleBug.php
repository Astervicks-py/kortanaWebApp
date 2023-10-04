<div class="bug <?php echo $bug['fixed'] ? "fixed" : "" ?>" data-id="<?php echo $bug['id'] ?>" >
    <div class="bug-first-sect">
        <div class="title_desc">
            <h3 class="title"><?php echo $bug['title'] ?></h3>
            <p><?php echo substr($bug['description'],0,20) . "..." ?></p>
        </div>
        <div class="action-btns">
            <button data-id="<?php echo $bug['id'] ?>" <?php echo $bug['fixed'] ? "" : "onclick='fixBug(this)'" ?>  style="background:green;color:#fff;"><?php echo $bug['fixed'] ? "RESOLVED" : "FIX" ?></button>
            <button data-id="<?php echo $bug['id'] ?>">SHOW</button>
            <button data-id="<?php echo $bug['id'] ?>" onclick="deleteBug(this)" style="background:red;">DELETE</button>
        </div>
    </div>
    
    <div class="details">
        <div><b>TITLE:</b> <span><?php echo $bug['title'] ?></span></div>
        <br />
        <div>
            <b>DESCRIPTION:</b> <br /> &nbsp;&nbsp; <span><?php echo $bug['description'] ?></span>
        </div>
        <br />
        <div>
            <b>IDEAS:</b> <br />  &nbsp;&nbsp; <span><?php echo $bug['idea'] ?></span>
        </div>
        <br />
        <div>
            <b>LOCATION:</b> <span><?php echo $bug['file_page'] ?> </span> &nbsp;&nbsp; 
            <span><b>ln: <?php echo $bug['line'] ?></b></span>
        </div>
        <br/>
        <div>
            <span><?php echo $bug['date'] ?></span>
        </div>
    </div>
</div>