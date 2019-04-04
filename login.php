<?php
require_once 'database.php';
include 'classes/User.php';
session_start();
error_log(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        if(!isset($_POST['username'], $_POST['password'])){
            die('Username and/or password does not exist!');
            header('location: /cse201/index.php');
        }else {
            
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $user = new User($pdo);
            if($user->validateUser($username, $password)){
                echo "success";
                $_SESSION['user'] = $results['username'];
            }else{
                echo "fail";
                $_SESSION
            }
        }
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$connection = null;
}else {
    header('location: /cse201/index.php');
}
?>