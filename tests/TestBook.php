<?php
    
    declare(strict_types=1);
    require_once "database.php";
    use PHPUnit\Framework\TestCase;
    
    class TestBook extends TestCase {

        public function testCanAddBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $this->assertTrue($book->addBook("mybook", "1st", "me", "none", 1));
        }
        
        public function testApproveBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $bookID = $book->getBookIDByName("mybook");
            $book->approveBook($bookID);
            $results = $book->readApproveBit($bookID);
            $this->assertEquals(1, $results);
        }

        public function testCanDeleteBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $bookID = $book->getBookIDByName("mybook");
            $this->assertTrue($book->deleteBook($bookID));
        }

    }

?>