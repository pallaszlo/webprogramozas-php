<?php

// =============================================================
// 5.15. Munkamenetadatok tárolása és olvasása
// =============================================================

session_start();

// Adatok tárolása
$_SESSION['felhasznalonev'] = 'kovacs_peter';
$_SESSION['felhasznalo_id'] = 42;
$_SESSION['admin'] = false;

// Adatok olvasása
if (isset($_SESSION['felhasznalonev'])) {
    echo "Bejelentkezett: "
        . htmlspecialchars(
            $_SESSION['felhasznalonev'],
            ENT_QUOTES,
            'UTF-8'
        );
}
