-- Film MVC – adatbázis-inicializáló szkript
-- Futtatás: mysql -u root < setup.sql (az újrafuttatás alaphelyzetbe állít)
-- (vagy a setup.php böngészőből vagy parancssorból, amely ugyanezt a szkriptet hajtja végre)

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS film_mvc
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE film_mvc;

DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS genres;

CREATE TABLE films (
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

-- 4. feladat: műfajok (Genre modell)
CREATE TABLE genres (
    id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO genres (name) VALUES
    ('Akció'), ('Animáció'), ('Bűnügyi'), ('Dráma'),
    ('Fantasy'), ('Sci-fi'), ('Thriller');
