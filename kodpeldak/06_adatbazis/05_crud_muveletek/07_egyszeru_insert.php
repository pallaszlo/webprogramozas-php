<?php

// =============================================================
// 6.12. Egyszerű INSERT
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// A bemutató nem módosítja tartósan az adatbázist: a műveletek egy
// tranzakcióban futnak, amelyet a fájl végén visszavonunk.
$pdo->beginTransaction();
// A példa a már meglévő kiss_janos felhasználót szúrja be, ezért előbb töröljük.
$pdo->exec("DELETE FROM users WHERE username = 'kiss_janos'");

try {
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, age)
        VALUES (:username, :email, :age)
    ");

    $stmt->execute([
        'username' => 'kiss_janos',
        'email'    => 'kiss.janos@example.com',
        'age'      => 25
    ]);

    $lastId = (int) $pdo->lastInsertId(); // PDO stringként adja vissza, ezért cast szükséges
    echo "Új felhasználó azonosítója: " . $lastId;

} catch (PDOException $e) {
    error_log("Beszúrási hiba: " . $e->getMessage());
    die("Beszúrási hiba.");
}

// Kiegészítés (nem szerepel a könyvben): a módosítások visszavonása
if ($pdo->inTransaction()) {
    $pdo->rollBack();
}
