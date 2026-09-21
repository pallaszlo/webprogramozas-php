<?php

// =============================================================
// 8.7–8.8. A .env betöltése és a változók olvasása
// =============================================================

// --- 8.7. .env betöltése phpdotenv segítségével --------------

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


// --- 8.8. Környezeti változók olvasása -----------------------

$dbHost = $_ENV['DB_HOST'];
$dbName = $_SERVER['DB_NAME'];

// Kiegészítés (nem szerepel a könyvben): a beolvasott értékek
var_dump($dbHost, $dbName);


// Kiegészítés (nem szerepel a könyvben): a 8.9. kódpélda kapcsolódása
try {
    require __DIR__ . '/db.php';
    echo "Sikeres kapcsolódás." . PHP_EOL;
} catch (PDOException $e) {
    echo "Kapcsolódási hiba (a .env adatai csak példák): " . $e->getMessage() . PHP_EOL;
}
