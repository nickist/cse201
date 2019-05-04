DROP DATABASE IF EXISTS thatzthebookdb;

CREATE DATABASE IF NOT EXISTS thatzthebookdb;

CREATE USER 'thatzthebookuser'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON thatzthebookdb . * TO 'thatzthebookuser'@'localhost';

USE thatzthebookdb;

CREATE TABLE users (
    userID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    fees DECIMAL(15,4) DEFAULT 0.0,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL DEFAULT 'user',
    passhash VARCHAR(255) NOT NULL,
    filePath VARCHAR(255) DEFAULT 'user/img/default.png'
);

CREATE TABLE libraries (
    libraryID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    libraryName VARCHAR(100) NOT NULL,
    libraryAddress VARCHAR(100) NOT NULL
);

CREATE TABLE books (
    bookID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    bookName VARCHAR(255) NOT NULL,
    bookAddition VARCHAR(50),
    author VARCHAR(100),
    filePath VARCHAR(255),
    libraryID INT NOT NULL,
    dueDate DATETIME NULL DEFAULT NULL,
    isapproved TINYINT DEFAULT 0,
    FOREIGN KEY FK_libraryID(libraryID) 
    REFERENCES libraries(libraryID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    userID INT NULL,
    FOREIGN KEY FK_userID(userID) 
    REFERENCES users(userID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE reviews (
    reviewID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    review  INT NOT NULL,
    bookID INT NOT NULL,
    FOREIGN KEY FK_bookID(bookID) 
    REFERENCES books(bookID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE comments (
    commentID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    commentContents TEXT,
    fkbookID INT NOT NULL,
    fkuserID INT NOT NULL,
    commentTitle VARCHAR(255),
    FOREIGN KEY FKuserID(fkuserID) 
    REFERENCES users(userID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY FKbookID(fkbookID) 
    REFERENCES books(bookID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
INSERT INTO libraries(libraryName, libraryAddress)
VALUES('Smith Library','441 S Locust St, Oxford, OH 45056');
INSERT INTO libraries(libraryName, libraryAddress)
VALUES('King Library','151 S Campus Ave, Oxford, OH 45056');
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('Head First Software Development', 1,'10th','Pilone, Dan','https://images-na.ssl-images-amazon.com/images/I/51zZxBQCVbL._SX430_BO1,204,203,200_.jpg',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('The Hobbit', 1,'5th','J.R.R. Tolkien','https://images-na.ssl-images-amazon.com/images/I/51uLvJlKpNL._SX321_BO1,204,203,200_.jpg',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('The Catcher in the Rye',  1,'3rd','J.D. Salinger','https://images-na.ssl-images-amazon.com/images/I/81OthjkJBuL.jpg',2);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('Atlas Shrugged',  1,'1st','Ayn Rand','https://images.penguinrandomhouse.com/cover/9780525948926',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('The Fountainhead',  1,'5th','Ayn Rand','https://images.penguinrandomhouse.com/cover/9780452286757',2);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('The Lord of the Rings',  1,'7th','J.R.R Tolkien','https://images-na.ssl-images-amazon.com/images/I/51tW-UJVfHL._SX321_BO1,204,203,200_.jpg',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('Harry Potter and the Sorcerers Stone',  1,'9th','J.K. Rowling','https://images-na.ssl-images-amazon.com/images/I/51HSkTKlauL._SX346_BO1,204,203,200_.jpg',2);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('The Great Gatsby',  1,'2nd','F Scott Fitzgerald','https://upload.wikimedia.org/wikipedia/en/thumb/f/f7/TheGreatGatsby_1925jacket.jpeg/220px-TheGreatGatsby_1925jacket.jpeg',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES('Harry Potter and the Order of the Phoenix',  1,'5th','J.K. Rowling','https://images-na.ssl-images-amazon.com/images/I/51lFAzVQUxL._SX342_BO1,204,203,200_.jpg',1);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES("Harry Potter and the Prisoner of Azkaban", 0, "5th", "J.K. Rowling", "https://images-na.ssl-images-amazon.com/images/I/81lAPl9Fl0L.jpg", 2);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES("Harry Potter and the Chamber of Secrets", 0, "5th", "J.K. Rowling", "https://images-na.ssl-images-amazon.com/images/I/51jNORv6nQL._SX340_BO1,204,203,200_.jpg", 2);
INSERT INTO books (bookName, isapproved, bookAddition, author, filePath, libraryID)
VALUES("All Quiet on the Western Front", 0, "5th", "Erich Maria Remarque", "https://images.penguinrandomhouse.com/cover/9780449911495", 2);
INSERT INTO users (username, name, passhash, position)
VALUES ('nickist','nick','$2y$12$zENgdAky36t15RNazJ1WkuUdRoLph6kjc5ZPG7RDxeOKhqIvR6J8G','admin');
INSERT INTO users (username, name, passhash, position)
VALUES ('TomRyan','tom','$2y$12$W324x/oqIQHl6QucLDlSeejaeOeWscK4Rl.5cOEdMBD/cuPkAh8o6','user');DROP DATABASE IF EXISTS thatzthebookdb;





