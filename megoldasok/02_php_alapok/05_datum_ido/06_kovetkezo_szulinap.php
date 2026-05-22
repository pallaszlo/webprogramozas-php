<?php

// ============================================================
// 6. feladat – Hány nap van a következő születésnapig?
// ============================================================

function kovetkezoSzulinap(string $szuletesiDatum): int|string
{
    $ma          = new DateTime('today');
    $szuletesNap = new DateTime($szuletesiDatum);

    // Születésnap az idei évben
    $szulinapIden = new DateTime(
        $ma->format('Y') . '-' . $szuletesNap->format('m-d')
    );

    // Ha ma van a születésnap
    if ($szulinapIden->format('Y-m-d') === $ma->format('Y-m-d')) {
        return "Boldog születésnapot!";
    }

    // Ha már elmúlt idén, jövőre számítjuk
    if ($szulinapIden < $ma) {
        $szulinapIden->modify('+1 year');
    }

    return (int) $ma->diff($szulinapIden)->days;
}

// Tesztek
$datumok = [
    '1990-05-10',
    '1985-04-30',   // ha ma 2026-04-30: boldog születésnapot
    '2000-12-25',
];

foreach ($datumok as $datum) {
    $eredmeny = kovetkezoSzulinap($datum);
    if (is_string($eredmeny)) {
        echo "$datum → $eredmeny" . PHP_EOL;
    } else {
        echo "$datum → $eredmeny nap van még a születésnapig" . PHP_EOL;
    }
}
