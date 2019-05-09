<?php
    declare(strict_types=1);
    require_once "database.php";
    use PHPUnit\Framework\TestCase;
    
    final class UserTest extends TestCase{

        public function testCanValidateFromValid(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $this->assertTrue($user->validateUser("nickist","jimmyjohns"));
        }

        public function testAddUserValid(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $this->assertTrue($user->addUser("souy","guyspassword","guy","user/img/default.png"));
        }
        
        public function testCantAddDuplicateUser(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $this->assertFalse($user->addUser("souy","guyspassword","guy","user/img/default.png"));
        }

        public function testUpdateUserValue(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $userID = $user->getUserIDByName("souy");
            $valueupdated = $user->updateUser($userID, "name", "kjbuuv");
            $this->assertEquals("kjbuuv", $valueupdated);
        }

        public function testCanDeleteUser(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $userID = $user->getUserIDByName("souy");
            $this->assertTrue($user->deleteUser($userID));
        }

        public function testCantDeleteNoneUser(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $userID = $user->getUserIDByName("98yasd8fha9");
            $this->assertFalse($user->deleteUser($userID));
        }
        
        public function testGetFilePath(): void {
            $database = new database();
            $db = $database->connect();
            $user = new User($db);
            $file = $user->getFilePath("nickist");
            $this->assertEquals("user/img/default.png", $file);
        }

        
    }

?>