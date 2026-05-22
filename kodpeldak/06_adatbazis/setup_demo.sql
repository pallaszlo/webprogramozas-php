-- Demo adatbázis a példakódokhoz
-- Futtatás: mysql -u root -p < setup_demo.sql

CREATE DATABASE IF NOT EXISTS demo_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE demo_db;

DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100)  NOT NULL UNIQUE,
    email      VARCHAR(255)  NOT NULL UNIQUE,
    age        INT           NOT NULL,
    city       VARCHAR(100),
    created_at DATETIME      NOT NULL DEFAULT NOW()
);

CREATE TABLE accounts (
    id             INT           AUTO_INCREMENT PRIMARY KEY,
    account_number VARCHAR(20)   NOT NULL UNIQUE,
    owner_name     VARCHAR(100)  NOT NULL,
    balance        DECIMAL(12,2) NOT NULL DEFAULT 0.00
);

INSERT INTO users (username, email, age, city) VALUES
    ('kiss_janos',   'kiss.janos@example.com',   25, 'Budapest'),
    ('nagy_peter',   'nagy.peter@example.com',    32, 'Debrecen'),
    ('kovacs_anna',  'kovacs.anna@example.com',   28, 'Budapest'),
    ('toth_maria',   'toth.maria@example.com',    45, 'Pécs'),
    ('szabo_laszlo', 'szabo.laszlo@example.com',  19, 'Győr');

INSERT INTO accounts (account_number, owner_name, balance) VALUES
    ('12345', 'Kiss János',  5000.00),
    ('67890', 'Nagy Péter',  1000.00);
