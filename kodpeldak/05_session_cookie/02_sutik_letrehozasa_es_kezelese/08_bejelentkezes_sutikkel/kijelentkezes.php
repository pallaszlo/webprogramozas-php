<?php

// =============================================================
// 5.12. Bejelentkezés kezelése sütikkel (kijelentkezes.php)
// =============================================================

// kijelentkezes.php - süti törlése
setcookie("felhasznalo", "", [
    'expires' => time() - 3600,
    'path'    => '/'
]);

header("Location: login.php");
exit;
