-- Webshop adatbázis a gyakorló feladatokhoz
-- Futtatás: mysql -u root -p < setup_webshop.sql

CREATE DATABASE IF NOT EXISTS webshop
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE webshop;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255)  NOT NULL UNIQUE,
    price       DECIMAL(10,2) NOT NULL,
    stock       INT           NOT NULL DEFAULT 0,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    total_price DECIMAL(10,2) NOT NULL,
    created_at  DATETIME      NOT NULL
);

CREATE TABLE order_items (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT           NOT NULL,
    product_id INT           NOT NULL,
    quantity   INT           NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id)   REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO categories (name) VALUES ('Elektronika'), ('Könyvek'), ('Ruházat');

INSERT INTO products (name, price, stock, category_id) VALUES
    ('Laptop',         1499.99, 10, 1),
    ('Okostelefon',     799.00,  5, 1),
    ('PHP kézikönyv',   49.90, 20, 2),
    ('Póló',            29.90, 50, 3);
