<?php

// =============================================================
// 6.15. Egyszerű DELETE
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// A bemutató nem módosítja tartósan az adatbázist: a műveletek egy
// tranzakcióban futnak, amelyet a fájl végén visszavonunk.
$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => 1]);

    $affectedRows = $stmt->rowCount();

    if ($affectedRows > 0) {
        echo "Sikeres törlés!";
    } else {
        echo "Nem történt törlés (nincs ilyen azonosító).";
    }

} catch (PDOException $e) {
    if ((int)$e->getCode() === 23000) {
        echo "Nem törölhető, mert más rekordok hivatkoznak rá!";
    } else {
        error_log("Törlési hiba: " . $e->getMessage());
        echo "Törlési hiba.";
    }
}

// Kiegészítés (nem szerepel a könyvben): a módosítások visszavonása
if ($pdo->inTransaction()) {
    $pdo->rollBack();
}
