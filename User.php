<?php
include 'Database.php';
    class User {
        private $username;
        private $name;
        private $passhash;
        private $position;
        private $userID;

        function __construct() {
        }


        public function validateUser($username, $passhash) {
            
        }

        public function addUser($username, $password, $name, $position) {
            //add user to database using database class
            $database = new Database();
            $database->query('INSERT INTO users (username, name, passhash, position) 
            VALUES (:username, :name, :passhash, :position)');
            $username = htmlspecialchars($_POST['username']);
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $position = "user";
            $options = [
                'cost' => 12
            ];
            $passhash = password_hash($password, PASSWORD_BCRYPT, $options);
            $database->bind(":username", $username);
            $database->bind(":passhash", $passhash);
            $database->bind(":name", $name);
            $database->bind(":position", $position);

            $database->execute();

        }


        public function removeUser($userID) {
            //remove user from database usig db class
        }


        // --------------------------getters and setters---------------------------------
        public function getName(){ return $name; }
        public function getUsername(){ return $username; }
        public function getPosition(){ return $position; }
        public function getPasshash(){ return $passhash; }

        public function setName($name) { $this->$name = $name; }
        public function setUsername($username) { $this->$username = $username; }
        public function setPosition($position) { $this->$position = $position; }
        public function setPasshash($passhash) { $this->$passhash = $passhash; }

    };

?>