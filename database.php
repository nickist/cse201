<?php
    require_once 'config.php';
    class database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        private $charset = 'utf8';
        private $con;

        public function connect() {
            try{  
                $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
                $this->options = array (
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                    );

                $this->con = new PDO($this->dsn, $this->user, $this->pass, $this->options);
            }catch(PDOException $e) {
                echo "error" .  $e->getMessage();
            }
            return $this->con;
        }

        public function close(){
            $this->con = null;
        }
    }
?>