<?php
    class Book {

        private $id;
        private $bookName;
        private $author;
        private $userID;

        private $libraryID;
        private $con;

        public function __construct($pdo)
        {
            $this->con = $pdo;
        }

        public function defaultBooks(){
            $query = "
                    SELECT * 
                    FROM 
                        books
                            JOIN 
                        libraries ON books.libraryID = libraries.libraryID
                        WHERE isapproved = 1
                        ORDER BY books.bookName ;
                    ";
            $results = $this->con->query($query)->fetchAll();
            return $this->validateData($results);
        }

        public function readOne($id) {

            $query = "SELECT b.bookID, b.bookName, b.author, b.filePath, b.bookAddition, lib.libraryName, lib.libraryAddress, usr.username, usr.userID FROM books b 
            LEFT JOIN libraries lib ON b.libraryID = lib.libraryID
            LEFT JOIN users usr ON b.userID = usr.userID
            WHERE bookID=:bookID";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":bookID", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $this->validateData($stmt->fetchAll(PDO::FETCH_ASSOC));
        }

        public function addBook($bookName, $bookAddition, $author, $filePath, $libraryID){
            $query = "INSERT books (bookName, bookAddition, author, filePath, libraryID )
                        VALUES (:bookName, :addition, :author, :filePath, :libraryID)";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":bookName", $bookName, PDO::PARAM_INT);
            $stmt->bindParam(":addition", $bookAddition, PDO::PARAM_INT);
            $stmt->bindParam(":author", $author, PDO::PARAM_INT);
            $stmt->bindParam(":filePath", $filePath, PDO::PARAM_INT);
            $stmt->bindParam(":libraryID", $libraryID, PDO::PARAM_INT);
            return $this->validateData($stmt->execute());
        }

        private function getColumnName($name) {
            switch ($name) {
                case "bookName":
                    return "bookName";
                case "bookAddition":
                    return "bookAddition";
                case "bookID":
                    return "bookID";
                case "dueDate":
                    return "dueDate";
                case "isapproved":
                    return "isapproved";
                case "userID":
                    return "userID";
                case "author":
                    return "author";
                case "libraryName":
                    return "libraryName";
                case "libraryAddress":
                    return "libraryAddress";
                default:
                    return "bookName";
            }
        }

        private function validateData($data) {
            if(is_array($data)) {
                if (count($data) < 1) {
                    return json_encode(array("Message" => "No Data Found"));
                } else {
                    return json_encode($data);
                }
            } else {
                return $data;
            }
        }

        public function searchBook($search, $filter){
            $case = $this->getColumnName($filter);
            
            $query = "
            SELECT * 
            FROM 
                books
                    JOIN 
                libraries ON books.libraryID = libraries.libraryID
                WHERE isapproved = 1 AND $case like :search
                ORDER BY $case ;
            ";
            if(substr($search, -1) != "%") {
                $search = $search."%";
            }
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":search", $search, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(pdo::FETCH_ASSOC);
            return $this->validateData($data);
        }

        public function notApproved(){
            $query = "
                    SELECT * 
                    FROM 
                        books
                            JOIN 
                        libraries ON books.libraryID = libraries.libraryID
                        WHERE isapproved = 0
                        ORDER BY books.bookName ;
                    ";
            $results = $this->con->query($query)->fetchAll();
            return $this->validateData($results);
        }

        public function approveBook($id) {
                $query = "UPDATE books SET isapproved=1 WHERE bookID=:bookID";
                $stmt = $this->con->prepare($query);
                $stmt->bindParam(":bookID", $id, PDO::PARAM_INT);
                return $this->validateData($stmt->execute());
            
        }


        public function getColumn() {
            $query = "SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = N'books' AND TABLE_NAME = N'libraries' OR COLUMN_NAME = 'bookName' 
             OR COLUMN_NAME = 'bookAddition'  OR COLUMN_NAME = 'author' OR COLUMN_NAME = 'libraryName'";

            $results = $this->con->query($query)->fetchAll();
            return $this->validateData($results);
        }


        public function deleteBook($id) {
            $query = "DELETE FROM books WHERE bookID=:bookID";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":bookID", $id, PDO::PARAM_INT);
            return $this->validateData($stmt->execute());
        }

        public function checkOutBook($bookID, $userID) {

            if ($this->updateBook($bookID, "userID", $userID)) {
                $query = "SELECT DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
                $stmt = $this->con->prepare($query);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $dueDate = $results["DATE_ADD(CURDATE(), INTERVAL 7 DAY)"];

                return $this->validateData($this->updateBook($bookID, "dueDate", $dueDate));
            } else {
                return $this->validateData("");
            }
        }

        public function getUserBooks($userID) {
            if($userID == NULL) {
                return json_encode(false);
            }
            $query = "SELECT books.bookName, books.bookID, books.bookAddition, books.filePath, books.author, books.dueDate,
            libraries.libraryAddress, libraries.libraryName, 
            users.username, users.userID, users.fees
                FROM books JOIN libraries ON books.libraryID = libraries.libraryID
                    JOIN users ON books.userID = users.userID
                WHERE books.isapproved = 1 AND books.userID = :userID;";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            $stmt->execute();
            return $this->validateData($stmt->fetchAll(pdo::FETCH_ASSOC));
            
        }

        public function updateBookFees() {
            $query = "UPDATE books b 
            JOIN users u 
            ON b.userID = u.userID 
            SET u.fees =
                CASE
                    WHEN DATEDIFF(NOW(), b.dueDate) > 0 THEN 1.25*DATEDIFF(b.dueDate, NOW())	
                    ELSE u.fees END
                    WHERE b.dueDate IS NOT NULL";
            $stmt = $this->con->prepare($query);
            return $this->validateData($stmt->execute());
        }
        public function updateBook($bookID, $columnName, $columnValue) {
            $col = $this->getColumnName($columnName);
            $table ="";

            if (strpos($col, "library") !== false) {
                $table = "libraries";
            } else {
                $table = "books";
            }


            $query = "UPDATE books b JOIN libraries lib ON b.libraryID = lib.libraryID SET $col = :columnValue WHERE b.bookID=:bookID";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(":columnValue", $columnValue, PDO::PARAM_INT);
            $stmt->bindParam(":bookID", $bookID, PDO::PARAM_INT);
            return $this->validateData($stmt->execute());
        }

    }

?>