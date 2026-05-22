<?php

// ============================================================
// 2. feladat – String rövidítése maximális hosszra
// ============================================================

function truncate(string $szoveg, int $maxHossz): string
{
    if (strlen($szoveg) <= $maxHossz) {
        return $szoveg;
    }
    return substr($szoveg, 0, $maxHossz - 3) . "...";
}

// Tesztek
$szovegek = [
    "Rövid szöveg",
    "Ez egy pontosan tizenöt",
    "Ez egy hosszabb szöveg, amelyet rövidíteni kell a megadott limit miatt.",
];

$limit = 30;

foreach ($szovegek as $szoveg) {
    $roviditve = truncate($szoveg, $limit);
    printf("Eredeti (%d):  %s\n", strlen($szoveg), $szoveg);
    printf("Rövidítve:     %s\n\n", $roviditve);
}
