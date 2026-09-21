<?php

// =============================================================
// 5.9. header() függvény használata
// =============================================================

// Átirányítás másik oldalra
header("Location: login.php");

// HTTP válaszkód beállítása
header("HTTP/1.1 404 Not Found");

// Cache vezérlés
header("Cache-Control: no-cache, must-revalidate");

// Tartalomtípus beállítása
header("Content-Type: application/json");

// Fájl letöltésének kezdeményezése
header("Content-Disposition: attachment; filename=document.pdf");
