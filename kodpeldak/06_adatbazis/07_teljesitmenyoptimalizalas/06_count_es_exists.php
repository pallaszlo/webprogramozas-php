<?php

// =============================================================
// 6.24. COUNT(*) és EXISTS összehasonlítása
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$count = (int) $pdo->query("
    SELECT COUNT(*) FROM users
")->fetchColumn();

$stmt = $pdo->prepare("
    SELECT EXISTS(
        SELECT 1 FROM users WHERE email = :email
    )
");
$stmt->execute(['email' => 'kiss.janos@example.com']);

$exists = (bool) $stmt->fetchColumn();


// Kiegészítés (nem szerepel a könyvben): az eredmények
echo "Felhasználók száma: $count<br>";
echo "Létezik a kiss.janos@example.com: " . ($exists ? 'igen' : 'nem');
