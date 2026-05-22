<?php

// ============================================================
// 2. feladat – Futárszolgálat díjszámítása konstansokkal
// ============================================================

const SULYHATAR  = 30;    // kg
const ALAPDIJ    = 15;    // RON
const POTDIJ_KG  = 2;     // RON/kg

define("CEG_NEV", "SpeedEx Futar Kft.");

echo CEG_NEV . PHP_EOL;
echo "Súlyhatár: " . SULYHATAR . " kg" . PHP_EOL;
echo "Alapdíj: "   . ALAPDIJ   . " RON" . PHP_EOL;
echo "Pótdíj: "    . POTDIJ_KG . " RON/kg" . PHP_EOL;

echo PHP_EOL;

// Díjszámítás
$csomagok = [5, 18, 30, 42];

foreach ($csomagok as $suly) {
    if ($suly <= SULYHATAR) {
        $dij = ALAPDIJ;
    } else {
        $dij = ALAPDIJ + ($suly - SULYHATAR) * POTDIJ_KG;
    }
    echo "$suly kg-os csomag szállítási díja: $dij RON" . PHP_EOL;
}

echo PHP_EOL;

// Felülírás kísérlete – const nem módosítható futás közben
// ALAPDIJ = 20;  // Fatal error: Cannot assign to a const
// define("CEG_NEV", "Másik Kft.");  // Warning: Constant already defined
echo "A konstansok felülírása nem lehetséges futás közben." . PHP_EOL;
