<?php
    
    use PHPUnit\Framework\TestCase;
    
    final class userTest extends TestCase{

        public function testCanValidateFromValid(): void {
            $this->assertInstanceOf( 
                User::class,
                User::validateUser("nickist","jimmyjohns"),
            );
        }

        public function TestAddUserValid() {
            $this->assertInstanceOf( 
                User::Class,
                User::addUser("TomRyan","password","Person"),
            );
        }

        public function TestCannotValidateFromInvalid(): void {
            $this->assertInstanceOf(
                User::class,
                User::ValidateUser("","")
            );
        }

        public function TestCannotAddUserInvalid() {
            $this->assertInstanceOf(
                User::class,
                User::addUser("","","")
            );
        }

        public function TestgetName() {
            $this->assertInstanceOf(
                User::class,
                User::getName()
            );
        }
        
        public function TestGetUserName() {
            $this->assertInstanceOf(
                User::class,
                User::getUserName()
            );
        }

        public function TestGetPosition() {
            $this->assertInstanceOf(
                User::class,
                User::getPosition()
            );
        }

        public function TestGetUserID() {
            $this->assertInstanceOf(
                User::class,
                User::getUserID()
            );
        }
    }

?>