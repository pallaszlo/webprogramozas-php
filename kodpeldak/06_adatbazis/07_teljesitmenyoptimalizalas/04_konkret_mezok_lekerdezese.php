<?php

// =============================================================
// 6.22. SELECT * helyett konkrét mezők
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

// Kerülendő
$stmt = $pdo->query("SELECT * FROM users");

// Ajánlott
$stmt = $pdo->query("SELECT id, email, username FROM users");


// Kiegészítés (nem szerepel a könyvben): a lekért oszlopok száma
echo "Oszlopok: " . $stmt->columnCount();
