<?php
session_start();
    function loginUser($user) {
        $_SESSION['name'] = $user->getName();
        $_SESSION['userID'] = $user->getUserID();
        $_SESSION['username'] = $user->getUserName();
        $_SESSION['position'] = $user->getPosition();
        setcookie('userID', $user->getUserID(), time() + 25000, '/');
        setcookie('position', $user->getPosition(), time() + 25000, '/');
        setcookie('filePath', $user->getFilePath(), time() + 25000, '/');
    }
?>