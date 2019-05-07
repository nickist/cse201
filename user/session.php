<?php
include 'login.php';
include '../database.php';
include '../classes/User.php';
error_log(E_ALL);
ini_set('display_errors', 1);
$database = new Database();
$db = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['username'], $_POST['password'])){
            die('Username and/or password does not exist!');
        } else if (!isset($_SESSION['userID'])) {

            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $user = new User($db);
            if ($user->validateUser($username, $password)) {
                loginUser($user);
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("already logged in");
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['logout']) && isset($_SESSION['userID'])) {
        session_unset();        
        $isdead = session_destroy();
        session_write_close();
        setcookie('userID', '', -1, '/');
        setcookie('filePath', '', -1, '/');
        setcookie('position', '', -1, '/');
        header('Content-Type: application/json');
        echo json_encode("logged out");
    } else if (isset($_GET['getUsers']) && isset($_SESSION['position'])) {
        if($_SESSION['position'] == 'admin') {
            header('Content-Type: application/json');
            
            $user = new User($db);
            $data = $user->getUsers();
            echo $data;
        } else {
            echo "not and admin";
        }

    } else if (isset($_GET['deleteUser']) && isset($_SESSION['position'])) {
        if($_SESSION['position'] == 'admin') {
            $userID = htmlspecialchars($_GET['userID']);
            $user = new user($db);
            $data = $user->deleteUser($userID);
            echo $data;
        }
    } else if (isset($_GET['getFees']) && isset($_GET['userID'])) {
        $userID = htmlspecialchars($_GET['getFees']);
        $user = new user($db);
        $data = $user->getFees($userID);
        echo $data;
    } else if (isset($_GET['updateUser']) && ($_GET['userID'] == $_SESSION['userID']) || $_SESSION['position'] == 'admin') {
        $columnName = htmlspecialchars($_GET['tableColumnName']);
        $columnValue = htmlspecialchars($_GET['tableColumnValue']);
        $userID = htmlspecialchars($_GET['updateUser']);
            $user = new User($db);
            $data = $user->updateUser($userID, $columnName, $columnValue);
            echo $data;
    } else {
        echo "not logged in";
    }
} else {
    header('location: /cse201/index.html');
}

?>