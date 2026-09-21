-- Stocks API adatbázis a gyakorló feladatokhoz
-- Futtatás: mysql -u root -p < setup.sql (az újrafuttatás alaphelyzetbe állít)
-- (vagy a setup.php böngészőből vagy parancssorból, amely ugyanezt a szkriptet hajtja végre)

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS stocks_api
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE stocks_api;

DROP TABLE IF EXISTS stocks;
DROP TABLE IF EXISTS sectors;
DROP TABLE IF EXISTS users;

CREATE TABLE sectors (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE stocks (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    ticker       VARCHAR(10)   NOT NULL UNIQUE,
    company_name VARCHAR(100)  NOT NULL,
    sector_id    INT,
    price        DECIMAL(10,2) NOT NULL,
    created_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sector_id) REFERENCES sectors(id)
);

CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    email    VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO sectors (name) VALUES
    ('Technology'), ('Finance'), ('Healthcare'), ('Energy');

INSERT INTO stocks (ticker, company_name, sector_id, price) VALUES
    ('AAPL',  'Apple Inc.',        1, 189.30),
    ('MSFT',  'Microsoft Corp.',   1, 415.50),
    ('GOOGL', 'Alphabet Inc.',     1, 175.20),
    ('JPM',   'JPMorgan Chase',    2, 198.40),
    ('JNJ',   'Johnson & Johnson', 3, 147.80);

-- Mintafelhasználó: admin@example.com, jelszó: secret123
-- (a password_hash('secret123', PASSWORD_BCRYPT) kimenete)
INSERT INTO users (email, password) VALUES
    ('admin@example.com', '$2y$12$JYjFD.2VyqUN80c52Hh/beha2SF/xJs9CYcWjJH0P6D.DIz/5wjQa');
