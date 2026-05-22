<?php

// ============================================================
// 3. feladat – Számlaösszesítő
// ============================================================

$nev        = "Laptop";
$egysegAr   = 3200.00;  // float
$mennyiseg  = 2;         // int
$akcios     = true;      // bool

// Típusok ellenőrzése
echo "Változók típusai:" . PHP_EOL;
echo "  nev:       " . gettype($nev)       . PHP_EOL;
echo "  egysegAr:  " . gettype($egysegAr)  . PHP_EOL;  // PHP-ban a float típus neve "double"
echo "  mennyiseg: " . gettype($mennyiseg) . PHP_EOL;
echo "  akcios:    " . gettype($akcios)    . PHP_EOL;

echo PHP_EOL;

// Számítás
$vegOsszeg = $egysegAr * $mennyiseg;

if ($akcios) {
    $kedvezmeny = $vegOsszeg * 0.15;
    $vegOsszeg -= $kedvezmeny;
    echo "Kedvezmény (15%): -" . number_format($kedvezmeny, 2) . " RON" . PHP_EOL;
}

echo sprintf("Termék:     %s", $nev)                          . PHP_EOL;
echo sprintf("Egységár:   %.2f RON", $egysegAr)               . PHP_EOL;
echo sprintf("Mennyiség:  %d db", $mennyiseg)                 . PHP_EOL;
echo sprintf("Fizetendő:  %.2f RON", $vegOsszeg)              . PHP_EOL;
