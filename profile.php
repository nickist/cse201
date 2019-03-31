<?php
require __DIR__ .'/auth.php';
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    try {
        $connection = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
                header('location: /cse201/index.php');
            } else {
                header('location: /cse201/login.html');
            }
        
    }catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
$con = null;
}else {
    header('location: /cse201/index.php');
}
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
</head>

<body>

<header>
  <h1>ThatzTheApp</h1> 
    <div class="container" onclick="toggleMenu(this)">
    <div class="bar1"></div>
    <div class="bar2"></div>
    <div class="bar3"></div>
    </div>
    <ul id="menu-box" class="sidenav">
    <li><a href="/cse201/destroy.php">Log Out</a></li>
    <li><a onclick="document.getElementById('id01').style.display='block'">AddUser</a></li>
    </ul>

</header>   
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div id="id01" class="modal">
  
  <form class="modal-content animate" onSubmit = "return checkPassword(this)" action="/cse201/addUser.php" method="POST">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>

      <label for="psw"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="repassword" required>

      <label for="position"><b>Position</b></label>
      <input type="text" placeholder="Position" name="position" required>

      <button type="submit">AddUser</button>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>


    <div class="content">

    </div>

</body>

</html>
