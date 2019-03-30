<?php
    session_start();
    if(empty($_SESSION['user'])){
        header('location: /stateline/login.html');
        exit;
    }
?>