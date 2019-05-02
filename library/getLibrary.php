<?php
session_start();
ini_set('display_errors', 1);
include '../database.php';

$database = new Database();
$db = $database->connect();

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['library'])){
        $id=htmlspecialchars($_GET['library']);
        header('Content-Type: application/json');
        $query = "SELECT * FROM libraries";
            $results = $db->query($query)->fetchAll();
            $data = json_encode($results);

        echo $data;
    }
}

?>
              


