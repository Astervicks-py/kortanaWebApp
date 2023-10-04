<?php 
    if(isset($_GET['file']))
    {
        $filepath = "includes/".$_GET['file'];
        header("Cache-Control: public");
        header("Content-description: File Transfer");
        header("Content-Disposition: attachment; filename = " . basename($filepath) . "");
        header("Content-type: application/zip");
        header("Content-Transfer-Encoding: binary");
        readfile($filepath);
        exit();
    }

?>