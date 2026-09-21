<?php

// =============================================================
// 6.5. Paraméterek átadása az execute() metódussal
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';
// A bemutató nem módosítja tartósan az adatbázist: a műveletek egy
// tranzakcióban futnak, amelyet a fájl végén visszavonunk.
$pdo->beginTransaction();
// A példa a már meglévő kiss_janos felhasználót szúrja be, ezért előbb töröljük.
$pdo->exec("DELETE FROM users WHERE username = 'kiss_janos'");

$stmt = $pdo->prepare(
    "INSERT INTO users (username, age) VALUES (:username, :age)"
);

$stmt->execute([
    'username' => 'kiss_janos',
    'age'      => 25
]);

// Kiegészítés (nem szerepel a könyvben): az eredmény ellenőrzése
echo "Beszúrt sorok: " . $stmt->rowCount();
// Kiegészítés (nem szerepel a könyvben): a módosítások visszavonása
if ($pdo->inTransaction()) {
    $pdo->rollBack();
}
