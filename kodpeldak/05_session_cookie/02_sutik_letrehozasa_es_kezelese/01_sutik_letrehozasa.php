<?php

// =============================================================
// 5.5. Sütik létrehozása különböző beállításokkal
// =============================================================

// Egyszerű süti 1 órás lejárattal
setcookie("felhasznalo", "kovacs_peter", ['expires' => time() + 3600, 'path' => '/']);

// Tartós süti biztonsági beállításokkal
setcookie("beallitasok", "sotetmod=1", [
    'expires'  => time() + 30 * 24 * 60 * 60,  // 30 nap
    'path'     => '/',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Süti törlése (lejárt idővel)
setcookie("felhasznalo", "", ['expires' => time() - 3600, 'path' => '/']);
