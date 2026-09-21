<?php

// ============================================================
// 3. feladat – Szökőév meghatározása
// ============================================================

$ev = 2024;

if ($ev % 400 === 0) {
    $szokEv   = true;
    $indoklas = "osztható 400-zal";
} elseif ($ev % 100 === 0) {
    $szokEv   = false;
    $indoklas = "osztható 100-zal, de nem 400-zal";
} elseif ($ev % 4 === 0) {
    $szokEv   = true;
    $indoklas = "osztható 4-gyel, de nem 100-zal";
} else {
    $szokEv   = false;
    $indoklas = "nem osztható 4-gyel";
}

$eredmeny = $szokEv ? "szökőév" : "nem szökőév";

echo "$ev $eredmeny." . PHP_EOL;
echo "Indoklás: $indoklas." . PHP_EOL;
