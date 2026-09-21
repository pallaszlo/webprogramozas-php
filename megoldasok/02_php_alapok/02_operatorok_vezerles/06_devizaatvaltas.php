<?php

// ============================================================
// 6. feladat – Devizaátváltási táblázat (RON → EUR, USD, GBP)
// ============================================================

// Árfolyamok: 1 egység idegen pénznem hány RON
$arfolyamok = [
    'EUR' => 5.0,
    'USD' => 4.5,
    'GBP' => 5.8,
];

// Fejléc
printf("%-10s", "RON");
foreach ($arfolyamok as $penznem => $arfolyam) {
    printf(" %10s", $penznem);
}
printf("\n%s\n", str_repeat("-", 44));

// Külső ciklus: a sorok 100-tól 1000-ig, 100-as lépésekben
for ($ron = 100; $ron <= 1000; $ron += 100) {
    printf("%-10d", $ron);

    // Belső ciklus: az összeg átváltása minden pénznemre
    foreach ($arfolyamok as $arfolyam) {
        printf(" %10.2f", $ron / $arfolyam);
    }

    echo "\n";
}
