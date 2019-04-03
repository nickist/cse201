<?php
    require_once 'config.php';
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $dbname = DB_NAME;
        $charset = 'utf8';
        
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $options = array (
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            );

        $pdo = new PDO($dsn, $user, $pass, $options);
   /* }catch(PDOException $e) {
        echo "error" .  $e->getMessage();
    }
*/
?>