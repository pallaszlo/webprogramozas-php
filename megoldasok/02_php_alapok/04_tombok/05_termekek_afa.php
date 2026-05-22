<?php

// ============================================================
// 5. feladat – Raktáron lévő termékek ÁFA-val növelt ára
// ============================================================

$termekek = [
    ['nev' => 'Laptop',   'ar' => 3200, 'raktaron' => 5],
    ['nev' => 'Monitor',  'ar' => 850,  'raktaron' => 0],
    ['nev' => 'Billentyuzet', 'ar' => 120, 'raktaron' => 12],
    ['nev' => 'Eger',     'ar' => 45,   'raktaron' => 0],
    ['nev' => 'Headset',  'ar' => 280,  'raktaron' => 3],
];

// Raktáron lévők szűrése
$raktaronLevo = array_filter($termekek, fn($t) => $t['raktaron'] > 0);

// ÁFA (21%) hozzáadása
$afasTermekek = array_map(
    fn($t) => array_merge($t, ['arAfa' => round($t['ar'] * 1.21, 2)]),
    $raktaronLevo
);

// Kimenet
printf("%-16s %8s %10s %6s\n", "Termék", "Nettó", "Bruttó (21%)", "Készlet");
printf("%s\n", str_repeat("-", 44));

foreach ($afasTermekek as $termek) {
    printf(
        "%-16s %8.2f %10.2f %6d db\n",
        $termek['nev'],
        $termek['ar'],
        $termek['arAfa'],
        $termek['raktaron']
    );
}
