<?php
    class User {
        private $username;
        private $name;
        private $position;
        private $userID;
        private $con;
        private $filePath;
        function __construct($pdo) {
            $this->con = $pdo;
        }

        public function validateUser($username, $password) {

            if($username == "" || $password == "") {
                return false;
            }

            $statement = $this->con->prepare("SELECT * FROM users WHERE username=:username"); 
            $statement->bindParam(':username', $username);
            $statement->execute();
            $results = $statement->fetch(PDO::FETCH_ASSOC);
            $verify = $results['passhash'];
            if (password_verify($password, $verify)) {
                $this->username = $results['username'];
                $this->name = $results['name'];
                $this->position = $results['position'];
                $this->userID = $results['userID'];
                $this->filePath = $results['filePath'];
                return true;
            } else {
                return false;
            }
        }

        private function getColumnName($columnName) {
            switch ($columnName) {
                case "passhash":
                    return "passhash";
                case "position":
                    return "position";
                case "username":
                    return "username";
                case "fees":
                    return "fees";
                case "name":
                    return "name";
                default:
                    return "username";
            }
        }

        public function updateUser($userID, $columnName, $columnValue) {
            $col = $this->getColumnName($columnName);

            $query = "UPDATE users u SET $col = :columnValue WHERE u.userID = :userID";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":columnValue", $columnValue, PDO::PARAM_INT);
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            return json_encode($stmt->execute());
        }



        public function addUser($username, $password, $name, $filePath) {

            if($username == "" || $password == "" || $name == "") {
                return false;
            }
            //check if user already exists
            $statement = $this->con->prepare("SELECT * FROM users WHERE username=:username"); 
            $statement->bindParam(':username', $username);
            $statement->execute();
            
            if ($statement->rowCount() > 0) {
                return false;
            } else {
                $position = "user";
                $options = [
                    'cost' => 12
                ];
                $passhash = password_hash($password, PASSWORD_BCRYPT, $options);
                $statement = $this->con->prepare('INSERT INTO users (username, name, passhash, filePath) 
                VALUES (:username, :name, :passhash, :filePath)');
                $statement->bindParam(":username", $username);
                $statement->bindParam(":passhash", $passhash);
                $statement->bindParam(":filePath", $filePath);
                $statement->bindParam(":name", $name);

                $statement->execute();
                $this->con = null;
                return true;
            }

        }

        public function getFees($userID) {
            $query = "SELECT fees FROM users WHERE userID = :userID";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        }

        public function getJson() {
            return get_object_vars($this);
        }

        public function getUsers() {
            $statement = $this->con->prepare("SELECT username, userID, name FROM users"); 
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($results);
        }

        public function removeUser($userID) {
            //remove user from database usig db class admin only

        }
        public function updateUsername($userID) {
            //update username

        }
        public function updatePassword($userID) {
            //change password

        }
        public function changePosition($userID) {
            //change position admin only

        }
        public function getName() { return $this->name; }
        public function getUserName() { return $this->username; }
        public function getPosition() { return $this->position; }
        public function getUserID() { return $this->userID; }
        public function getFilePath() { return $this->filePath; }
    };

?>