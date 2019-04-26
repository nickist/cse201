<?php
    session_start();
    if(empty($_SESSION['username']) && $_SESSION['position'] != 'admin'){
        
        exit;
    } else if ($_SESSION['position'] == 'user') {
        
    }
?>