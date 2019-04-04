<?php
    class Book {

        private $con;

        public function __construct($pdo)
        {
            $this->con = $pdo;
        }

        public function defaultBooks(){
            $query = "
                    SELECT  books.author, books.bookName, libraries.libraryName, books.filePath 
                    FROM 
                        books
                            JOIN 
                        libraries ON books.libraryID = libraries.libraryID
                        ORDER BY books.bookName ;
                    ";
            return $this->con->query($query)->fetchAll();
        }

    }

?>