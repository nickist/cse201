<?php
require_once 'config.php';
session_start();
error_log(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        $connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(!isset($_POST['username'], $_POST['password'])){
            die('Username and/or password does not exist!');
            header('location: /stateline/login.html');
        }else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $_SESSION['username'] = $username;

            $statement = $connection->prepare("SELECT * FROM users WHERE username=:username"); 
            $statement->bindParam(':username', $username);
            $statement->execute(['username' => $username]);
            $results = $statement->fetch();
            $verify = $results[2];
            if(password_verify($password, $verify)) {
                $_SESSION['user'] = $results[0];
                header('location: /stateline/index.php');
            } else {
                header('location: /stateline/login.html');
            }
        }
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$con = null;
}else {
    header('location: /stateline/index.php');
}
?>