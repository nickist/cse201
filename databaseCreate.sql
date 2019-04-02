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
VALUES('King Library','151 S Campus Ave, Oxford, OH 45056');
INSERT INTO books (bookName, bookAddition, author, filePath, libraryID)
VALUES('Atlas Shrugged','1st','Ayn Rand ','http://img1.imagesbn.com/p/9780452286368_p0_v1_s260x420.jpg',1);