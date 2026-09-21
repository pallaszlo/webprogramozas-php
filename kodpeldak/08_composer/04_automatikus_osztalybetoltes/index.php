<?php

// =============================================================
// 8.3. Autoloader betöltése
// =============================================================
// Futtatás előtt: composer dump-autoload (külső csomag nincs, ezért install sem kell)

require __DIR__ . '/vendor/autoload.php';

// Ezt követően az osztályok automatikusan betöltődnek
use App\Controllers\HomeController;
use App\Models\User;

$controller = new HomeController();
$user = new User();

// Kiegészítés (nem szerepel a könyvben): a betöltött osztályok
echo get_class($controller) . PHP_EOL;
echo get_class($user) . PHP_EOL;
