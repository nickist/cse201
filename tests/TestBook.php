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

        public function testCanUpdateBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $bookID = $book->getBookIDByName("mybook");
            $book->updateBook($bookID, "bookName", "somethingDifferent");
            $results = $book->getBookNameByID($bookID);
            $this->assertEquals("somethingDifferent", $results);
        }

        public function testCanCheckoutBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $bookID = $book->getBookIDByName("somethingDifferent");
            $book->checkOutBook($bookID, 1);
            $results = $book->getBookCheckedOutBy(1, $bookID);
            $this->assertEquals("nickist", $results);

        }

        public function testCanDeleteBook(): void {
            $database = new database();
            $db = $database->connect();
            $book = new Book($db);
            $bookID = $book->getBookIDByName("somethingDifferent");
            $this->assertTrue($book->deleteBook($bookID));
        }

        

    }

?>