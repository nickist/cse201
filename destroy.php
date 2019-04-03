<?php
    include 'auth.php';
    session_unset();
    session_destroy();
    header('location: /cse201/index.php');
?>