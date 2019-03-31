<?php
require_once 'config.php';
error_log(E_ALL);
ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD'] === 'POST' /**&& username,  password correct */) {
    session_start();
    
    try {
        $connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(!isset($_POST['username'], $_POST['password'], $_POST['repassword'])){
            die('Username and/or password does not exist!');
            header('location: login.html');
        }else {

            $statement = $connection->prepare("INSERT INTO users (username, passhash, position) 
            VALUES (:username, :passhash, :position)");

            $username = $_POST['username'];
            $password = $_POST['password'];
            $position = $_POST['position'];
            $options = [
                'cost' => 12
            ];
            $passhash = password_hash($password, PASSWORD_BCRYPT, $options);
            $statement->bindparam(":username", $username);
            $statement->bindparam(":passhash", $passhash);
            $statement->bindparam(":position", $position);

            $statement->execute();

            echo "new Records created";


            header('location: index.php');
        }
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$con = null;
}else {
    header('location: index.php');
}
?>