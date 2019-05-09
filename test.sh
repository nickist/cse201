!#/bin/bash

./vendor/bin/phpunit --bootstrap classes/User.php --testdox tests/UserTest.php
./vendor/bin/phpunit --bootstrap classes/Book.php --testdox tests/TestBook.php