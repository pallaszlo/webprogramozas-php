<?php

// =============================================================
// 6.9. Pozícióalapú helyőrzők használata
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$stmt = $pdo->prepare("
    SELECT * FROM users
    WHERE age > ? AND age < ? AND city = ?
");

$stmt->execute([18, 65, 'Budapest']);

// Kiegészítés (nem szerepel a könyvben): a találatok kiírása
foreach ($stmt->fetchAll() as $row) {
    echo htmlspecialchars($row['username']) . " ({$row['age']}) - "
        . htmlspecialchars($row['city']) . "<br>";
}
