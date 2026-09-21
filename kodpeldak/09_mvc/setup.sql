-- A 9. fejezet példáinak adatbázisa (student_mvc).
-- Futtatás: mysql -u root -p < setup.sql (az újrafuttatás alaphelyzetbe állít)
-- (vagy a setup.php böngészőből vagy parancssorból, amely ugyanezt a szkriptet hajtja végre)

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS student_mvc
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE student_mvc;

DROP TABLE IF EXISTS students;

CREATE TABLE students (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students (name, email) VALUES
    ('Nagy János',   'nagy.janos@example.com'),
    ('Kovács Éva',   'kovacs.eva@example.com'),
    ('Tóth Péter',   'toth.peter@example.com');
