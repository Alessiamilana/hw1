CREATE DATABASE GALLERY;
USE GALLERY;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE books (
    isbn VARCHAR(255) PRIMARY KEY,
    titolo VARCHAR(255) NOT NULL,
    prezzo FLOAT NOT NULL,
    copertina VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE books_favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    isbn VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (isbn) REFERENCES books(isbn)
) ENGINE=InnoDB;

CREATE TABLE books_carrello (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    isbn VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (isbn) REFERENCES books(isbn)
) ENGINE=InnoDB;

CREATE TABLE card_owner (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    card_owner_name VARCHAR(255) NOT NULL,
    card_owner_surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE purchases ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_owner_id INT NOT NULL,
    stato_ordine VARCHAR(255),
    FOREIGN KEY (card_owner_id) REFERENCES card_owner(id)
) ENGINE=InnoDB;

