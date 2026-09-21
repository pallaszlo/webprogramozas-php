<?php

// =============================================================
// 6.2. Integritási megszorítás kezelése
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// a kiss_janos felhasználó már létezik, ezért a beszúrás integritási hibát ad

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (email, username) VALUES (:email, :username)"
    );

    $stmt->execute([
        'email'    => 'kiss.janos@example.com',
        'username' => 'kiss_janos',
    ]);

    echo "Sikeres regisztráció!";
} catch (PDOException $e) {

    if ($e->getCode() == 23000) {
        echo "Integritási hiba történt (duplikált adat).";
    } else {
        error_log("Adatbázis-hiba: " . $e->getMessage());
        echo "Hiba történt a művelet során.";
    }
}
