<?php

// =============================================================
// 6.8. Névvel ellátott helyőrzők használata
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$stmt = $pdo->prepare("
    SELECT * FROM users
    WHERE age > :min_age
      AND age < :max_age
      AND city = :city
");

$stmt->execute([
    'min_age' => 18,
    'max_age' => 65,
    'city'    => 'Budapest'
]);

// Kiegészítés (nem szerepel a könyvben): a találatok kiírása
foreach ($stmt->fetchAll() as $row) {
    echo htmlspecialchars($row['username']) . " ({$row['age']}) - "
        . htmlspecialchars($row['city']) . "<br>";
}
