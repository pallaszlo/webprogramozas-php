<?php

// =============================================================
// 5.12. Bejelentkezés kezelése sütikkel (fooldal.php)
// =============================================================

// fooldal.php - védett oldal ellenőrzése
if (!isset($_COOKIE['felhasznalo'])) {
    header("Location: login.php");
    exit;
}

echo "Üdvözöljük, "
    . htmlspecialchars($_COOKIE['felhasznalo'], ENT_QUOTES, 'UTF-8')
    . "!";

// Kiegészítés (nem szerepel a könyvben): kijelentkezési link
echo '<p><a href="kijelentkezes.php">Kijelentkezés</a></p>';
