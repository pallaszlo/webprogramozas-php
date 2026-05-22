<?php

// ============================================================
// 5. feladat – Szövegfeldolgozás beépített stringfüggvényekkel
// ============================================================

$mondat = "Ez egy teszt mondat 42 szammal es admin@example.ro email-cimmel.";

// 1. Karakterek száma szóközök nélkül
$szokozNelkul = str_replace(" ", "", $mondat);
$hossz        = strlen($szokozNelkul);
echo "Karakterszám szóközök nélkül: $hossz" . PHP_EOL;

// 2. Csupa kisbetű
$kisbetus = strtolower($mondat);
echo "Kisbetűsen: $kisbetus" . PHP_EOL;

// 3. Számjegyek cseréje '#'-re
$szamokNelkul = preg_replace('/[0-9]/', '#', $mondat);
echo "Számjegyek helyett #: $szamokNelkul" . PHP_EOL;

// 4. '@' karakter megléte
if (strpos($mondat, "@") !== false) {
    echo "A mondat tartalmaz '@' karaktert." . PHP_EOL;
} else {
    echo "A mondat nem tartalmaz '@' karaktert." . PHP_EOL;
}
