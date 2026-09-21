<?php

// =============================================================
// 5.16. Munkamenetadatok törlése
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
session_start();
$_SESSION['felhasznalo_id'] = 42;


// Egy konkrét változó törlése
unset($_SESSION['felhasznalo_id']);

// Teljes kijelentkezés:
// adatok törlése + munkamenet megszüntetése
session_unset();
session_destroy();

// A session süti törlése a böngészőből is
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
