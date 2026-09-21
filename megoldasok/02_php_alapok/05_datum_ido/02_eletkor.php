<?php

// ============================================================
// 2. feladat – Életkor kiszámítása születési dátumból
// ============================================================

function eletkor(string $szuletesiDatum): int
{
    $szuletesNap = new DateTime($szuletesiDatum);
    $ma          = new DateTime('today');
    return (int) $ma->diff($szuletesNap)->y;
}

// Tesztek
$datumok = [
    '1990-06-15',
    '2000-01-01',
    '1985-12-31',
];

foreach ($datumok as $datum) {
    printf("Születési dátum: %s → Életkor: %d év\n", $datum, eletkor($datum));
}
