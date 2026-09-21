<?php

// =============================================================
// A példák közös adatbázis-kapcsolata (6.1. kódpélda)
// =============================================================

try {
    $pdo = new PDO(
        dsn: "mysql:host=localhost;dbname=mydb;charset=utf8mb4",
        username: "root",
        password: "",
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
