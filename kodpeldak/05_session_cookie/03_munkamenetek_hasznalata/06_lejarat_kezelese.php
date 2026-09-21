<?php

// =============================================================
// 5.19. Munkamenet lejáratának kezelése
// =============================================================

session_start();

// Inaktivitási időkorlát: 30 perc
$timeout = 1800;

if (isset($_SESSION['last_activity']) &&
    time() - $_SESSION['last_activity'] > $timeout) {

    session_unset();
    session_destroy();

    header('Location: login.php?timeout=1');
    exit;
}

$_SESSION['last_activity'] = time();
