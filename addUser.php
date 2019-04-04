<?php
include 'classes/User.php';
include 'database.php';
error_log(E_ALL);
ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD'] === 'POST' /**&& username,  password correct */) {
    session_start();
    
    try {

        if(!isset($_POST['username'], $_POST['password'], $_POST['repassword'])){
            die('Username and/or password does not exist!');
            session_unset();
            session_destroy();
            header('location: /cse201/index.php');
        }else {
            $user = new User($pdo);
            $user->addUser($_POST['username'], $_POST['password'], $_POST['name'], 'user');
            echo "success";
            header('location: /cse201/index.php');
        }
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$con = null;
}else {
    header('location: index.php');
}
?>