<?php

declare(strict_types=1);

// ============================================================
// 5. feladat – formatPrice() és applyDiscount() függvények
// ============================================================

function formatPrice(float $osszeg, string $penznem = 'RON', int $tizedesJegy = 2): string
{
    return number_format($osszeg, $tizedesJegy, '.', ',') . ' ' . $penznem;
}

function applyDiscount(float $osszeg, float $kedvezmeny = 0.10): float
{
    return $osszeg * (1 - $kedvezmeny);
}

// Alaphasználat
echo formatPrice(1499.9)                        . PHP_EOL;  // 1,499.90 RON
echo formatPrice(1499.9, 'EUR')                 . PHP_EOL;  // 1,499.90 EUR
echo formatPrice(1499.9, 'HUF', 0)             . PHP_EOL;  // 1,500 HUF

echo PHP_EOL;

// Kedvezmény alkalmazása
$ar        = 3200.0;
$akcios    = applyDiscount($ar);           // 10% kedvezmény
$nagykedes = applyDiscount($ar, 0.25);     // 25% kedvezmény

echo "Eredeti ár:       " . formatPrice($ar)        . PHP_EOL;
echo "10% kedvezmény:   " . formatPrice($akcios)    . PHP_EOL;
echo "25% kedvezmény:   " . formatPrice($nagykedes) . PHP_EOL;

echo PHP_EOL;

// Strict types: hibás típusú argumentum esetén TypeError kivétel
try {
    echo formatPrice("nem szam") . PHP_EOL;
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . PHP_EOL;
}
