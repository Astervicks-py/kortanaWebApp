<div class="loading-container">
    <div class="intro"> <?php echo $row['username']?> <br> <?php echo  $message ?></div>
    <div class="ring"></div>
    <span>Loading...</span>
    <div style="display:flex;justify-content:center;
        align-items:flex-end;gap:10px;font-size:1.5rem;position:absolute;bottom:5%">
        <p style="color:#737373">Kortana</p>
        <button style = "background:linear-gradient(to bottom,#50ff00,#0003ff,#ff0a00);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            border:solid 2px #0f0;
            padding:5px 10px;border-radius:10px;">
            Beta
        <button>

    </div>
</div>
<script>
   const loader = document.querySelector('.loading-container');

    window.onload = () =>
    {
        loader.style.display = "none";
    } 
</script>
