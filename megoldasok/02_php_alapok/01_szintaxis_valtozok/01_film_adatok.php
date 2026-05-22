<?php

// ============================================================
// 1. feladat – Film adatainak tárolása és kiírása háromféleképpen
// ============================================================

$cim      = "Inception";
$rendezo  = "Christopher Nolan";
$ev       = 2010;
$ertekeles = 9;

// 1. Összefűzés a . operátorral
echo "Cím: " . $cim . PHP_EOL;
echo "Rendező: " . $rendezo . PHP_EOL;
echo "Megjelenési év: " . $ev . PHP_EOL;
echo "Értékelés: " . $ertekeles . "/10" . PHP_EOL;

echo PHP_EOL;

// 2. String interpoláció
echo "Cím: $cim" . PHP_EOL;
echo "Rendező: $rendezo" . PHP_EOL;
echo "Megjelenési év: $ev" . PHP_EOL;
echo "Értékelés: $ertekeles/10" . PHP_EOL;

echo PHP_EOL;

// 3. Heredoc szintaxis
echo <<<EOT
Cím: $cim
Rendező: $rendezo
Megjelenési év: $ev
Értékelés: $ertekeles/10
EOT;
echo PHP_EOL;
