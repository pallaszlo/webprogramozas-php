<?php
// PDO kapcsolat létrehozása ajánlott konfigurációval (PHP 8+)

try {
    $pdo = new PDO(
        dsn: "mysql:host=localhost;dbname=demo_db;charset=utf8mb4",
        username: "root",
        password: "",
        options: [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

    echo "Sikeres kapcsolódás!";
    echo "<br>Driver: "         . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    echo "<br>Szerver verzió: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

} catch (PDOException $e) {
    // A hibaüzenetet soha ne jelenítsd meg a felhasználónak!
    error_log("Kapcsolódási hiba: " . $e->getMessage());
    die("Adatbázis-kapcsolódási hiba történt. Kérlek, próbáld újra később.");
}
