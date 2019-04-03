<?php
    require_once 'config.php';
    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;
        private $error;
        private $statement;
        
        public function __construct(){
                $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
                $options = array (
                    PDO::ATTR_PERSISTENT => true,  
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  
                    );

            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }catch(PDOException $e) {
                $this->error =  $e->getMessage();
            }
        }

        public function bind($param, $value, $type = null){  
            if (is_null($type)) {  
                switch (true) {  
                case is_int($value):  
                $type = PDO::PARAM_INT;  
                break;  
                case is_bool($value):  
                $type = PDO::PARAM_BOOL;  
                break;  
                case is_null($value):  
                $type = PDO::PARAM_NULL;  
                break;  
                default:  
                $type = PDO::PARAM_STR;  
                }  
            }  
            $this->statement->bindParam($param, $value);  
        } 

        public function query($query) {
                $this->statement = $this->dbh->prepare($query);
        }        
        
        public function execute() {
            return $this->statement->execute();
        }

        public function resultset() {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insert() {
            
        }

        public function delete() {
            
        }   

        public function update() {
            
        }

    }


?>