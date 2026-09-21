<?php

// =============================================================
// 5.6. Sütik olvasása
// =============================================================

// Süti közvetlen olvasása
if (isset($_COOKIE['felhasznalo'])) {
    echo "Üdvözöljük, " . htmlspecialchars($_COOKIE['felhasznalo']) . "!";
}

// Olvasás alapértelmezett értékkel
$tema = $_COOKIE['tema'] ?? 'vilagos';

// Összes süti kiírása
foreach ($_COOKIE as $nev => $ertek) {
    echo htmlspecialchars($nev) . ": " .
         htmlspecialchars($ertek) . "<br>";
}
