-- =============================================================
-- 7.6. Adatbázisséma (database.sql)
-- =============================================================

CREATE DATABASE IF NOT EXISTS student_api
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE student_api;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP
);

-- Példa adatok
INSERT INTO students (name, email) VALUES
('Nagy János', 'nagy.janos@example.com'),
('Kiss Anna', 'kiss.anna@example.com'),
('Kovács Péter', 'kovacs.peter@example.com');
