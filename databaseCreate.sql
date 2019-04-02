CREATE TABLE users (
    userID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username NVARCHAR(100) NOT NULL,
    name NVARCHAR(100) NOT NULL,
    passhash NVARCHAR(255) NOT NULL
);

CREATE TABLE libraries (
    libraryID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    libraryName NVARCHAR(100) NOT NULL,
    libraryAddress NVARCHAR(100) NOT NULL
);

CREATE TABLE books (
    bookID INT(1) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    bookName NVARCHAR(255) NOT NULL,
    bookAddition NVARCHAR(50),
    author NVARCHAR(100),
    filePath NVARCHAR(255),
    libraryID INT NOT NULL,
    FOREIGN KEY FK_libraryID(libraryID) 
    REFERENCES libraries(libraryID)
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
    commentTitle NVARCHAR(255),
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
INSERT INTO books (bookName, bookAddition, author, filePath, libraryID)
VALUES('Head First Software Development: A Learner\'s Companion to Software Development','10th','Pilone, Dan','http://it-ebooks.info/images/ebooks/3/head_first_software_development.jpg',2);