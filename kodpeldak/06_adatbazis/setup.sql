-- Az adatbázis a 6. fejezet kódpéldáihoz
-- Futtatás: mysql -u root -p < setup.sql
-- (vagy böngészőből a setup.php, amely ugyanezt a szkriptet hajtja végre)
-- Az újrafuttatás visszaállítja az adatbázis kiinduló állapotát.

CREATE DATABASE IF NOT EXISTS mydb
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE mydb;

DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS users;

-- Az e-mail-cím és az életkor elhagyható, mert a könyv egyes példái
-- (6.2., 6.5.) csak néhány oszlopot töltenek ki.
CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL UNIQUE,
    email      VARCHAR(255) UNIQUE,
    age        INT,
    city       VARCHAR(100),
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT           NOT NULL,
    total      DECIMAL(10,2) NOT NULL,
    created_at DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE accounts (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    account_number VARCHAR(20)   NOT NULL UNIQUE,
    owner_name     VARCHAR(100)  NOT NULL,
    balance        DECIMAL(12,2) NOT NULL DEFAULT 0.00
);

CREATE TABLE transactions (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    from_account VARCHAR(20)   NOT NULL,
    to_account   VARCHAR(20)   NOT NULL,
    amount       DECIMAL(12,2) NOT NULL,
    created_at   DATETIME      NOT NULL
);

INSERT INTO users (username, email, age, city, created_at) VALUES
    ('kiss_janos',   'kiss.janos@example.com',   25, 'Budapest', '2026-01-10 09:00:00'),
    ('nagy_peter',   'nagy.peter@example.com',   32, 'Debrecen', '2026-02-14 10:30:00'),
    ('kovacs_anna',  'kovacs.anna@example.com',  28, 'Budapest', '2026-03-03 14:15:00'),
    ('toth_maria',   'toth.maria@example.com',   45, 'Pécs',     '2026-04-21 08:45:00'),
    ('szabo_laszlo', 'szabo.laszlo@example.com', 19, 'Győr',     '2026-05-30 16:20:00');

INSERT INTO orders (user_id, total, created_at) VALUES
    (1, 1499.99, '2026-06-01 10:00:00'),
    (1,   29.90, '2026-06-15 12:30:00'),
    (2,  149.00, '2026-06-20 09:10:00'),
    (3,  599.00, '2026-07-02 18:05:00'),
    (3,   19.90, '2026-07-05 11:40:00');

INSERT INTO accounts (account_number, owner_name, balance) VALUES
    ('12345', 'Kiss János', 5000.00),
    ('67890', 'Nagy Péter', 1000.00);
