<?php

// ============================================================
// 3. feladat – Palindrom ellenőrzés
// ============================================================

function palindromE(string $szoveg): bool
{
    // Szóközök és írásjelek eltávolítása, kisbetűsítés
    $tisztitott = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $szoveg));
    return $tisztitott === strrev($tisztitott);
}

// Tesztek
$peldak = [
    "racecar",
    "A man a plan a canal Panama",
    "hello",
    "Was it a car or a cat I saw",
    "PHP",
];

foreach ($peldak as $pelda) {
    $eredmeny = palindromE($pelda) ? "palindrom" : "nem palindrom";
    printf("%-36s → %s\n", "\"$pelda\"", $eredmeny);
}
