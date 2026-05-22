<?php
// Adatbázis-kapcsolat a webshop adatbázishoz
// Módosítsd az adatokat a saját környezetednek megfelelően

$host     = 'localhost';
$dbname   = 'webshop';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        dsn: "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        username: $username,
        password: $password,
        options: [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log("Kapcsolódási hiba: " . $e->getMessage());
    die("Adatbázis-kapcsolódási hiba történt.");
}
