<?php
include 'login.php';
include '../database.php';
include '../classes/User.php';
error_log(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

        if (!isset($_POST['username'], $_POST['name'],  $_POST['password'], $_POST['repassword'])){
            echo json_encode(array("Message" => "Invalid Username or Password"));
            session_unset();
            session_destroy();
            header('location: ../index.html');
        } if($_POST['password'] == $_POST['repassword']) {
            echo json_encode(array("Message" => "passwords do not match"));

        } else if (isset($_POST['username'])){

            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image";
                    $uploadOk = 1;
                } else {
                    echo json_encode(array("Message" => "File is not an image."));
                    $uploadOk = 0;
                }
                    // header('location: ../index.html');

            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $counter = 0;
                $newName = "";
                $path_parts = pathinfo($target_file);
                while (file_exists($target_file)) {
                    $newName = $path_parts['dirname']."/".$path_parts['filename']."_". $counter. "." . $path_parts['extension'];
                    $target_file = $newName;
                    $counter++;
              }
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 50000000) {
                echo json_encode(array("Message" => "Sorry, your file is too large."));
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo json_encode(array("Message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo json_encode(array("Message" => "Sorry, your file was not uploaded."));
                $target_file = "img/default.png";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $database = new Database();
                    $db = $database->connect();
                    $username = htmlspecialchars($_POST['username']);
                    $name = htmlspecialchars($_POST['name']);
                    $password = htmlspecialchars($_POST['password']);
                    $user = new User($db);
                    $file = "user/" . $target_file;
                    if($user->addUser($username, $password, $name, $file)) {
                        loginUser($user);
                        header("location: ../index.html");
                    } else {
                        echo json_encode(array("Message" => "user created"));
                    }
                } else {
                    $database = new Database();
                    $db = $database->connect();
                    $username = htmlspecialchars($_POST['username']);
                    $name = htmlspecialchars($_POST['name']);
                    $password = htmlspecialchars($_POST['password']);
                    $user = new User($db);
                    $file = "user/".$target_file;
                    $user->addUser($username, $password, $name, $file);
                    echo json_encode(array("Message" => "Sorry, there was an error uploading your file. a default was used"));
                    header("location: ../index.html");
                }
            }

            
        } else {
            session_unset();
            session_destroy();
            echo "FAIL";
        }

} else {
    header('location: ../index.html');
}
?>