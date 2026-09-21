<?php

// =============================================================
// 6.10. Lekérési módok összefoglalása
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require __DIR__ . '/../db.php';

// fetch() - egyetlen sor, például ID alapú kereséshez
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => 1]);
$user = $stmt->fetch(); // FETCH_ASSOC az alapértelmezett (ajánlott beállítás)

// fetchAll() - összes sor tömbként
$stmt = $pdo->query("SELECT id, username FROM users ORDER BY username ASC");
$users = $stmt->fetchAll();

// fetchColumn() - egyetlen oszlop értéke
$count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
echo "Felhasználók száma: " . $count;


// Kiegészítés (nem szerepel a könyvben): a lekért adatok
echo "<br>fetch(): " . htmlspecialchars($user['username']);
echo "<br>fetchAll(): " . count($users) . " sor";
