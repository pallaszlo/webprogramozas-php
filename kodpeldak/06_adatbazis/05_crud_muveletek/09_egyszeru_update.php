<?php

// =============================================================
// 6.14. Egyszerű UPDATE
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// A bemutató nem módosítja tartósan az adatbázist: a műveletek egy
// tranzakcióban futnak, amelyet a fájl végén visszavonunk.
$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare("
        UPDATE users
        SET email = :email, age = :age
        WHERE id = :id
    ");

    $stmt->execute([
        'email' => 'kovacs.peter@example.com',
        'age'   => 26,
        'id'    => 1
    ]);

    $affectedRows = $stmt->rowCount();

    if ($affectedRows > 0) {
        echo "Sikeres módosítás!";
    } else {
        echo "Nincs módosítható rekord ezzel az azonosítóval.";
    }

} catch (PDOException $e) {
    error_log("Módosítási hiba: " . $e->getMessage());
    die("Módosítási hiba.");
}

// Kiegészítés (nem szerepel a könyvben): a módosítások visszavonása
if ($pdo->inTransaction()) {
    $pdo->rollBack();
}
