<?php

// =============================================================
// 5.10. Átirányítás helyes használata
// =============================================================

if (!isset($_COOKIE['user'])) {
    header("Location: login.php");
    exit;
}

echo "Üdvözöljük az oldalon!";
