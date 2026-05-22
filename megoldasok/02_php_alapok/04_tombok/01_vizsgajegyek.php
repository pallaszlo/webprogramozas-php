<?php

// ============================================================
// 1. feladat – Vizsgajegyek elemzése (rendező függvény nélkül)
// ============================================================

$jegyek = [7, 4, 9, 6, 8, 5, 10, 3, 7, 8];

// Átlag
$osszeg = 0;
foreach ($jegyek as $jegy) {
    $osszeg += $jegy;
}
$atlag = $osszeg / count($jegyek);

// Legjobb és leggyengébb (rendező nélkül)
$legjobb    = $jegyek[0];
$leggyengebb = $jegyek[0];

foreach ($jegyek as $jegy) {
    if ($jegy > $legjobb)    $legjobb     = $jegy;
    if ($jegy < $leggyengebb) $leggyengebb = $jegy;
}

// Átlag feletti tanulók
$atlagFelett = 0;
foreach ($jegyek as $jegy) {
    if ($jegy > $atlag) $atlagFelett++;
}

echo "Jegyek:          " . implode(", ", $jegyek) . PHP_EOL;
echo sprintf("Átlag:           %.2f\n", $atlag);
echo "Legjobb jegy:    $legjobb" . PHP_EOL;
echo "Leggyengébb:     $leggyengebb" . PHP_EOL;
echo "Átlag felett:    $atlagFelett tanuló" . PHP_EOL;
