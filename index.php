<?php
require_once 'config.php';
session_start();
error_log(E_ALL);
ini_set('display_errors', 1);


    try {
        $connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare("
        SELECT books.bookName, books.author, libraries.libraryName, books.filePath 
        FROM 
            books
                JOIN 
            libraries ON books.libraryID = libraries.libraryID
            ORDER BY books.bookName ;
        "); 
        $statement->execute();
        $results = $statement->setFetchMode(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$connection = null;
?>

<!DOCTYPE html>
<html lang="en">
        <head>
        <title> ThatzTheApp</title>
        <meta charset="utf-8">
        <link href="/cse201/styling/style.css" rel="stylesheet">
        <link href="/cse201/styling/modalStyle.css" rel="stylesheet">
        <script src="/cse201/scripts/index.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        </head>

        <header>
        <h1>thatzapp</h1>
        <div class="container" onclick="toggleMenu(this)">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <ul id="menu-box" class="sidenav">
            <span class="login"><li><a onclick="document.getElementById('loginID').style.display='block'">Login</a></li></span>
            <span class="logout" ><li><a href="/cse201/destroy.php">Log Out</a></li></span>
            <li><a onclick="document.getElementById('addUserID').style.display='block'">AddUser</a></li>
        </ul>

        </header>

    <body>

        <div id="loginID" class="modal">

            <form class="modal-content animate" onSubmit="return checkPassword(this)" action="/cse201/login.php" method="POST">
            <span onclick="document.getElementById('loginID').style.display = 'none'" class="close" title="Close Modal">&times;</span>

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit">AddUser</button>

            <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('loginID').style.display = 'none'" class="cancelbtn">Cancel</button>
            </div>
            </form>
        </div>

        <div id="addUserID" class="modal">

            <form class="modal-content animate" onSubmit="return checkPassword(this)" action="/cse201/addUser.php" method="POST">
            <span onclick="document.getElementById('addUserID').style.display = 'none'" class="close" title="Close Modal">&times;</span>

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

             <label for="name"><b>Username</b></label>
            <input type="text" placeholder="Name" name="name" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="psw"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="repassword" required>

            <label for="position"><b>Position</b></label>
            <input type="text" placeholder="Position" name="position" required>

            <button type="submit">AddUser</button>

            <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('addUserID').style.display = 'none'" class="cancelbtn">Cancel</button>
            </div>
            </form>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('addUserID');
            var loginmodal = document.getElementById('loginID');
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }else if (event.target == loginmodal) {
                    loginmodal.style.display = "none";
                }
            }
        </script>
            <div class="content">
                <?php          
                    //echo "<table style='border: solid 1px black; margin-top: 2px;'>";
                    //echo "<tr><th>bookName</th><th>Author</th><th>Library</th></tr>";   
                    $data = $statement->fetchAll();
                    foreach ($data as $dat) {
                        //image file path
                        $filepath = $dat['filePath'];
                        $style = "width:128px;height:150px";
                        $format = sprintf("<h3>%s</h3><h5>  %s  %s </h5>", $dat['bookName'], $dat['author'], $dat['libraryName']);
                        
                        echo $format;
                        echo "<img src=$filepath style=$style>";
                    }

                    echo "</table>";
                ?>
            </div>

    </body>
</html>

