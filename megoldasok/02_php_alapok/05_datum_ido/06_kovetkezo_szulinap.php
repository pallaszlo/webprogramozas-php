<?php

// ============================================================
// 6. feladat – Hány nap van a következő születésnapig?
// ============================================================

// A következő születésnapig hátralévő napok száma (születésnapon 0)
function kovetkezoSzulinap(string $szuletesiDatum): int
{
    $ma          = new DateTime('today');
    $szuletesNap = new DateTime($szuletesiDatum);

    // Születésnap az idei évben
    $szulinapIden = new DateTime(
        $ma->format('Y') . '-' . $szuletesNap->format('m-d')
    );

    // Ha már elmúlt idén, jövőre számítjuk
    if ($szulinapIden < $ma) {
        $szulinapIden->modify('+1 year');
    }

    return (int) $ma->diff($szulinapIden)->days;
}

// Tesztek
$datumok = [
    '1990-05-10',
    date('Y-m-d', strtotime('-30 years')),   // ma 30 éves: boldog születésnapot
    '2000-12-25',
];

foreach ($datumok as $datum) {
    $napok = kovetkezoSzulinap($datum);
    if ($napok === 0) {
        echo "$datum → Boldog születésnapot!" . PHP_EOL;
    } else {
        echo "$datum → $napok nap van még a születésnapig" . PHP_EOL;
    }
}
