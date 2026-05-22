<?php

// ============================================================
// 1. feladat – Aritmetikai műveletek két számmal
// ============================================================

$a = 15;
$b = 4;

echo "$a + $b = " . ($a + $b)   . PHP_EOL;
echo "$a - $b = " . ($a - $b)   . PHP_EOL;
echo "$a * $b = " . ($a * $b)   . PHP_EOL;
echo "$a / $b = " . ($a / $b)   . PHP_EOL;
echo "$a % $b = " . ($a % $b)   . PHP_EOL;  // maradék
echo "$a ** $b = " . ($a ** $b) . PHP_EOL;  // hatványozás

echo PHP_EOL;

// Nullával való osztás kezelése
$c = 0;

if ($c !== 0) {
    echo "$a / $c = " . ($a / $c) . PHP_EOL;
} else {
    echo "Nullával való osztás nem lehetséges." . PHP_EOL;
}
