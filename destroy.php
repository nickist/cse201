<?php
    include 'auth.php';
    session_unset();
    session_destroy();
    header('location: /stateline/login.html');
?>