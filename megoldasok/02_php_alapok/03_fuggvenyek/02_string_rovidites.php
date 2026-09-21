<?php

// ============================================================
// 2. feladat – Sztring rövidítése maximális hosszra
// ============================================================

// Az mb_ függvények karakterekben számolnak, így az ékezetes
// betűk sem vágódnak ketté (a strlen() és a substr() bájtalapúak).
function truncate(string $szoveg, int $maxHossz): string
{
    if (mb_strlen($szoveg) <= $maxHossz) {
        return $szoveg;
    }
    return mb_substr($szoveg, 0, $maxHossz - 3) . "...";
}

// Tesztek
$szovegek = [
    "Rövid szöveg",
    "Ez a mondat harminc karakteres",
    "Ez egy hosszabb szöveg, amelyet rövidíteni kell a megadott limit miatt.",
];

$limit = 30;

foreach ($szovegek as $szoveg) {
    $roviditve = truncate($szoveg, $limit);
    printf("Eredeti (%d):  %s\n", mb_strlen($szoveg), $szoveg);
    printf("Rövidítve:     %s\n\n", $roviditve);
}
