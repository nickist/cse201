<?php
session_start();
ini_set('display_errors', 1);
include '../database.php';
include '../classes/Book.php';

$database = new Database();
$db = $database->connect();

if(!isset($_SESSION['userID'])) {
    setcookie('userID', '', -1, '/');
    setcookie('position', '', -1, '/');
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['bookID'])){
        $id = htmlspecialchars($_GET['bookID']);
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->readOne($id);
        echo $data;
    }else if(isset($_GET['search'])) {
        $search = htmlspecialchars($_GET['search']);
        $filter = htmlspecialchars($_GET['filter']);
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->searchBook($search, $filter);
        echo $data;
    } else if(isset($_GET['getUsersBooks'])) {
        $userID = htmlspecialchars($_GET['getUsersBooks']);
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->getUserBooks($userID);
        echo $data;
    } else if (isset($_GET['checkOutBook'])) {
        $userID = $_SESSION['userID'];
        $bookID = htmlspecialchars($_GET['checkOutBook']);
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->checkOutBook($bookID, $userID);
        echo $data;
    } else if (isset($_GET['columnName'])) { 
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->getColumn();
        echo $data;
    } else if (isset($_GET['approve']) && $_SESSION['position'] == 'admin') { 
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->notApproved();
        echo $data;
    } else if (isset($_GET['approveBook']) && $_SESSION['position'] == 'admin') { 
        $id = htmlspecialchars($_GET['approveBook']);
        $approveBit = htmlspecialchars($_GET['approveBit']);
        header('Content-Type: application/json');
        if ($approveBit == 1) {
            $book = new Book($db);
            $data = $book->approveBook($id);
            echo $data;
        } else if ($approveBit == 0) {
            $book = new Book($db);
            $data = $book->deleteBook($id);
            echo $data;
        }
    } else if(isset($_GET["updateFees"])) {

        $book = new Book($db);
        $data = $book->updateBookFees();
        echo $data;
    } else if (isset($_GET['updateBook']) && $_SESSION['position'] == 'admin') {

            $columnName = htmlspecialchars($_GET['tableColumnName']);
            $columnValue = htmlspecialchars($_GET['tableColumnValue']);
            $bookID = htmlspecialchars($_GET['updateBook']);
                $book = new Book($db);
            $data = $book->updateBook($bookID, $columnName, $columnValue);
            echo $data;
        
    } else if (isset($_GET['deleteBook']) && $_SESSION['position'] == 'admin') { 
        header('Content-Type: application/json');
        $id = $_GET['deleteBook'];
        $book = new Book($db);
        $data = $book->deleteBook($id);
        echo $data;
    } else if (isset($_GET['columnNames'])) { 
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->getColumns();
        echo $data;
    } else if(isset($_GET['books'])){
        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->defaultBooks();
        echo $data;
    } else {
        echo json_encode("Nothing To Return");
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['userID'])) {
        $bookname = htmlspecialchars($_POST['bookName']);
        $addition = htmlspecialchars($_POST['addition']);
        $author = htmlspecialchars($_POST['author']);
        $filePath = htmlspecialchars($_POST['filePath']);
        $libraryID = htmlspecialchars($_POST['libraryID']);

        header('Content-Type: application/json');
        $book = new Book($db);
        $data = $book->addBook($bookname, $addition, $author, $filePath, $libraryID);
        echo  json_encode($data);
    } else {
        echo "not logged in";
    }
} else {
    header('location: /cse201/index.html');
}

?>
              


