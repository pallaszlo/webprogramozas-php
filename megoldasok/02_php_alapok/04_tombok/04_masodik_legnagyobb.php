<?php

// ============================================================
// 4. feladat – Tömb második legnagyobb eleme (rendező nélkül)
// ============================================================

function masodikLegnagyobb(array $tomb): int|float|null
{
    if (count($tomb) < 2) {
        return null;
    }

    $legnagyobb = PHP_INT_MIN;
    $masodik    = PHP_INT_MIN;

    foreach ($tomb as $elem) {
        if ($elem > $legnagyobb) {
            $masodik    = $legnagyobb;
            $legnagyobb = $elem;
        } elseif ($elem > $masodik && $elem !== $legnagyobb) {
            $masodik = $elem;
        }
    }

    return $masodik === PHP_INT_MIN ? null : $masodik;
}

// Tesztek
$tombок = [
    [3, 1, 4, 1, 5, 9, 2, 6],
    [10, 10, 10],
    [42, 17],
    [7],
];

foreach ($tombок as $tomb) {
    $eredmeny = masodikLegnagyobb($tomb);
    $eredmenyStr = $eredmeny !== null ? (string) $eredmeny : "nincs";
    printf("[%s] → második legnagyobb: %s\n", implode(", ", $tomb), $eredmenyStr);
}
