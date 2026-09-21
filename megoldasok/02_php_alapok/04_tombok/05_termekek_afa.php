<?php

// ============================================================
// 5. feladat – Raktáron lévő termékek áfával növelt ára
// ============================================================

$termekek = [
    ['nev' => 'Laptop',       'ar' => 3200, 'raktaron' => 5],
    ['nev' => 'Monitor',      'ar' => 850,  'raktaron' => 0],
    ['nev' => 'Billentyűzet', 'ar' => 120,  'raktaron' => 12],
    ['nev' => 'Egér',         'ar' => 45,   'raktaron' => 0],
    ['nev' => 'Fejhallgató',  'ar' => 280,  'raktaron' => 3],
];

// Raktáron lévők szűrése
$raktaronLevo = array_filter($termekek, fn($t) => $t['raktaron'] > 0);

// Áfa (21%) hozzáadása
$afasTermekek = array_map(
    fn($t) => array_merge($t, ['arAfa' => round($t['ar'] * 1.21, 2)]),
    $raktaronLevo
);

// A printf() a szöveg hosszát bájtokban számolja, nem karakterekben.
// Ezért az ékezetes szövegeket karakterszám alapján egészítjük ki szóközökkel.
function kitolt(string $szoveg, int $szelesseg): string
{
    return $szoveg . str_repeat(' ', max(0, $szelesseg - mb_strlen($szoveg)));
}

// Kimenet
echo kitolt("Termék", 14) . kitolt("Nettó", 10) . kitolt("Bruttó (21%)", 14) . "Készlet" . PHP_EOL;
echo str_repeat("-", 46) . PHP_EOL;

foreach ($afasTermekek as $termek) {
    echo kitolt($termek['nev'], 14)
        . kitolt(number_format($termek['ar'], 2, '.', ''), 10)
        . kitolt(number_format($termek['arAfa'], 2, '.', ''), 14)
        . $termek['raktaron'] . " db" . PHP_EOL;
}
