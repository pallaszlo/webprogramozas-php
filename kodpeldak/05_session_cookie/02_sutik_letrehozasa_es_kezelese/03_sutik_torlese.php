<?php

// =============================================================
// 5.7. Sütik törlése
// =============================================================

// Egyszerű törlés
setcookie("felhasznalo", "", time() - 3600);

// Törlés azonos path/domain beállításokkal
setcookie("felhasznalo", "", [
    'expires' => time() - 3600,
    'path'    => '/',
    'domain'  => ''
]);

// Összes süti törlése
foreach ($_COOKIE as $nev => $ertek) {
    setcookie($nev, "", time() - 3600);
}
