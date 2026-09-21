<?php

// ============================================================
// 3. feladat – Palindrom ellenőrzés
// ============================================================

function palindromE(string $szoveg): bool
{
    // Csak a betűk és a számjegyek maradnak (\p{L}: bármely betű, az ékezetesek is),
    // majd kisbetűsítünk. A /u módosító UTF-8 szövegként kezeli a mintát.
    $tisztitott = mb_strtolower(preg_replace('/[^\p{L}\p{N}]/u', '', $szoveg));

    // A strrev() bájtonként fordítana meg, ezért karakterekre bontjuk a szöveget
    $karakterek = mb_str_split($tisztitott);
    return $karakterek === array_reverse($karakterek);
}

// Tesztek
$peldak = [
    "Indul a görög aludni",
    "Géza, kék az ég!",
    "Kis erdő",
];

foreach ($peldak as $pelda) {
    $eredmeny = palindromE($pelda) ? "palindrom" : "nem palindrom";
    echo "\"$pelda\" → $eredmeny" . PHP_EOL;
}
