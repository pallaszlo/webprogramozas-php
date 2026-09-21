<?php

// ============================================================
// 3. feladat – Két dátum között eltelt napok száma
// ============================================================

function napokKozott(string $datumEgy, string $datumKetto): int
{
    $d1 = new DateTime($datumEgy);
    $d2 = new DateTime($datumKetto);
    return (int) $d1->diff($d2)->days;
}

// Tesztek
$parok = [
    ['2025-01-01', '2025-12-31'],
    ['2024-02-01', '2024-03-01'],   // szökőév: február = 29 nap
    ['2026-04-01', '2026-04-30'],
];

foreach ($parok as [$tol, $ig]) {
    printf("%s → %s : %d nap\n", $tol, $ig, napokKozott($tol, $ig));
}
