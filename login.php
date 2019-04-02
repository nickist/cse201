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
            header('location: /cse201/index.php');
        }else {
            
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $_SESSION['username'] = $username;
            $statement = $connection->prepare("SELECT * FROM users WHERE username=:username"); 
            $statement->bindParam(':username', $username);
            $statement->execute(['username' => $username]);
            $results = $statement->fetch();
            $verify = $results[3];
            if(password_verify($password, $verify)) {
                $_SESSION['user'] = $results[0];
                header('location: /cse201/index.php');
            } else {
                header('location: /cse201/index.php');
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