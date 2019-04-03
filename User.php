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

        public function validateUser($username, $passhash) {
            
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
            $this->con->query('INSERT INTO users (username, name, passhash, position) 
            VALUES (:username, :name, :passhash, :position)');
            $this->con->bindParam(":username", $username);
            $this->con->bindParam(":passhash", $passhash);
            $this->con->bindParam(":name", $name);
            $this->con->bindParam(":position", $position);

            $this->con->execute();
            $this->con->close();

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