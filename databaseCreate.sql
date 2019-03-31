﻿CREATE TABLE users (
    userID INT IDENTITY (1,1) NOT NULL PRIMARY KEY,
    username NVARCHAR(100) NOT NULL,
    name NVARCHAR(100) NOT NULL,
    passhash NVARCHAR(255) NOT NULL
);
GO 

CREATE TABLE libraries (
    libraryID INT IDENTITY (1,1) NOT NULL PRIMARY KEY,
    libraryName NVARCHAR(100) NOT NULL,
    libraryAddress NVARCHAR(100) NOT NULL
);
GO

CREATE TABLE books (
    bookID INT IDENTITY (1,1) NOT NULL PRIMARY KEY,
    bookName NVARCHAR(255) NOT NULL,
    bookAddition NVARCHAR(50) DEFAULT 'Unkown',
    author NVARCHAR(100) DEFAULT 'unkown',
    filePath NVARCHAR(255),
    FK_libraryID INT FOREIGN KEY REFERENCES libraries(libraryID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);
GO

CREATE TABLE reviews (
    reviewID INT IDENTITY (1,1) NOT NULL PRIMARY KEY,
    review  INT NOT NULL,
    FK_bookID INT FOREIGN KEY REFERENCES books(bookID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)

CREATE TABLE comments (
    commentID INT IDENTITY (1,1) NOT NULL PRIMARY KEY,
    commentContents TEXT,
    commentTitle NVARCHAR(255),
    FK_userID INT FOREIGN KEY REFERENCES users(userID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FK_bookID INT FOREIGN KEY REFERENCES books(bookID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)