<?php
    
    use PHPUnit\Framework\TestCase;
    
    final class TestBook extends TestCase{

        public function TestDefaultBook() {
            $this->assertInstanceOf(
                Book::class,
                Book::defaultBooks()
            );
        }

        public function TestreadOne() {
            $this->assertInstanceOf(
                Book::class,
                Book::readOne(1)
            );
        }

        public function TestaddBookValid() {
            $this->assertInstanceOf(
                Book::class,
                Book::addBook('The Hobbit', 1,'5th','J.R.R. Tolkien','https://images-na.ssl-images-amazon.com/images/I/51uLvJlKpNL._SX321_BO1,204,203,200_.jpg',1, 1)
            );
        }

        public function TestGetColumnName() {
            $this->assertInstanceOf(
                Book::class,
                Book::getColumnName("bookID");
            );
        }

        public function TestsearchBook() {
            $this->assertInstanceOf(
                Book::class,
                Book::searchBook("","")
            );
        }


        public function TestnotApproved() {
            $this->assertInstanceOf(
                Book::class,
                Book::notApproved()
            );
        }

        public function TestApprovedBooks() {
            $this->assertInstanceOf(
                Book::class,
                Book::approveBook(1)
            );
        }        

        public function TestGetColumn() {
            $this->assertInstanceOf(
                Book::class,
                Book::getColumn()
            );
        }

        public function TestdeleteBook() {
            $this->assertInstanceOf(
                Book::class,
                Book::deleteBook(1)
            );
        }

        public function TestUpdateBook() {
            $this->assertInstanceOf(
                Book::class,
                Book::updateBook(2, "author", "Me")
            );
        }
    }

?>