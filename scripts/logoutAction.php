<?php
    session_start();
    if(isset($_SESSION['pid'])){
        session_destroy();
    }
    echo "ok";
?>
