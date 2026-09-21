<?php

// ============================================================
// 2. feladat – Futárszolgálat díjszámítása konstansokkal
// ============================================================

const SULYHATAR  = 30;    // kg
const ALAPDIJ    = 15;    // RON
const POTDIJ_KG  = 2;     // RON/kg

define("CEG_NEV", "SpeedEx Futár Kft.");

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

// Kísérlet a konstans felülírására. A define() figyelmeztetést ad
// ("Constant CEG_NEV already defined"), false értéket ad vissza,
// és a konstans értéke nem változik.
$sikerult = define("CEG_NEV", "Másik Kft.");
var_dump($sikerult);                          // bool(false)
echo "A cég neve továbbra is: " . CEG_NEV . PHP_EOL;

// A const kulcsszóval létrehozott konstansnak értéket adni szintaktikai hiba,
// ezért a szkript el sem indulna. Ez a sor ezért csak megjegyzésben szerepel:
// ALAPDIJ = 20;  // Parse error: syntax error, unexpected token "="
