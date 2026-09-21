<?php

// =============================================================
// 6.20. N+1 lekérdezés problémája: hibás megközelítés
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

// 1 query: összes felhasználó lekérdezése
$stmt = $pdo->query("SELECT * FROM users LIMIT 10");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// N query: minden felhasználóhoz külön lekérdezés
foreach ($users as $user) {
    $stmt = $pdo->prepare("
        SELECT * FROM orders WHERE user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user['id']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Felhasználó: " . $user['email'] .
         " - Rendelések: " . count($orders) . "<br>";
}
