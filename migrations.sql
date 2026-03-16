CREATE DATABASE marketly;
USE marketly;

CREATE TABLE users (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(30) NOT NULL,
email VARCHAR(255) NOT NULL,
password_hash VARCHAR(255) NOT NULL,
created_at DATETIME NOT NULL,
permission_level ENUM("User", "Admin", "Owner") DEFAULT "User"
);

CREATE TABLE categories (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(50) NOT NULL
);

CREATE TABLE listings (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
title VARCHAR(50) NOT NULL,
description VARCHAR(255) NOT NULL,
price DECIMAL(10,2) NOT NULL,
user_id INT NOT NULL,
category_id INT NOT NULL,
created_at DATETIME NOT NULL,
status ENUM("Active", "Sold", "Deleted", "On Hold"),

FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE images (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
listing_id INT NOT NULL,
image_url VARCHAR(500) NOT NULL,

FOREIGN KEY (listing_id) REFERENCES listings(id)
);

CREATE VIEW listing_details AS
SELECT 
    u.username,
    u.email,
    c.name AS category_name,
    l.id AS listing_id,
    l.title,
    l.description,
    l.price,
    l.status,
    l.created_at,
    i.id AS image_id,
    i.image_url
FROM users u
JOIN listings l ON u.id = l.user_id
JOIN images i ON l.id = i.listing_id
JOIN categories c ON l.category_id = c.id;

CREATE VIEW listing AS
SELECT
    l.title,
    l.price,
    c.name AS category_name,
    u.username,
    l.status,
    l.created_at
FROM listings l
JOIN users u ON l.user_id = u.id
JOIN categories c ON l.category_id = c.id;


INSERT INTO categories (name)
VALUES
("Electronics"),
("Home"),
("Transport"),
("Clothes and Shoes"),
("Animals"),
("Properties"),
("Agriculture"),
("Construction"),
("Production"),
("Leisure and Hobbies");

