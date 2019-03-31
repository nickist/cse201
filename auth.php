<?php
    session_start();
    if(empty($_SESSION['user'])){
        header('location: /cse201/login.html');
        exit;
    }
?>