-- Film MVC – adatbázis inicializáló szkript
-- Futtatás: mysql -u root < setup.sql

CREATE DATABASE IF NOT EXISTS film_mvc
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE film_mvc;

CREATE TABLE IF NOT EXISTS films (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(200)  NOT NULL,
    director   VARCHAR(150)  NOT NULL,
    year       SMALLINT      NOT NULL,
    genre      VARCHAR(80)   NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO films (title, director, year, genre) VALUES
    ('Inception',           'Christopher Nolan',  2010, 'Sci-fi / Thriller'),
    ('The Godfather',       'Francis Ford Coppola', 1972, 'Dráma / Bűnügyi'),
    ('Spirited Away',       'Hayao Miyazaki',      2001, 'Animáció / Fantasy'),
    ('Parasite',            'Bong Joon-ho',        2019, 'Dráma / Thriller'),
    ('The Matrix',          'Lana és Lilly Wachowski', 1999, 'Sci-fi / Akció');
