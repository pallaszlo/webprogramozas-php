<?php

// =============================================================
// 6.11. Lekérés stdClass objektumként
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

$stmt = $pdo->query("SELECT id, username, email FROM users");
$users = $stmt->fetchAll(PDO::FETCH_OBJ);

foreach ($users as $user) {
    echo $user->username . " - " . $user->email . "<br>";
}
