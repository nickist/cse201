<?php
    class User {
        private $username;
        private $name;
        private $passhash;
        private $position;
        private $userID;
        private $con;
        function __construct($pdo) {
            $this->con = $pdo;
        }

        public function validateUser($username, $password) {

            $statement = $this->con->prepare("SELECT * FROM users WHERE username=:username"); 
            $statement->bindParam(':username', $username);
            $statement->execute();
            $results = $statement->fetch();
            $verify = $results['passhash'];
            if(password_verify($password, $verify)) {
                return true;
            } else {
                return false;
            }
            $this->con = null;
        }

        public function addUser($username, $password, $name, $position) {
            //add user to database using database class

            $username = htmlspecialchars($_POST['username']);
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $position = "user";
            $options = [
                'cost' => 12
            ];
            $passhash = password_hash($password, PASSWORD_BCRYPT, $options);
            $statement = $this->con->prepare('INSERT INTO users (username, name, passhash, position) 
            VALUES (:username, :name, :passhash, :position)');
            $statement->bindParam(":username", $username);
            $statement->bindParam(":passhash", $passhash);
            $statement->bindParam(":name", $name);
            $statement->bindParam(":position", $position);

            $statement->execute();
            $this->con = null;

        }


        public function removeUser($userID) {
            //remove user from database usig db class

        }
        public function updateUsername($userID) {
            //remove user from database usig db class

        }
        public function updatePassword($userID) {
            //remove user from database usig db class

        }
        public function changePosition($userID) {
            //remove user from database usig db class

        }

    };

?>