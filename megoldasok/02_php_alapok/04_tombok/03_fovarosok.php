<?php

// ============================================================
// 3. feladat – Ország–főváros kereső
// ============================================================

$fovarosok = [
    'Magyarország' => 'Budapest',
    'Románia'      => 'Bukarest',
    'Németország'  => 'Berlin',
    'Franciaország' => 'Párizs',
    'Olaszország'  => 'Róma',
    'Spanyolország' => 'Madrid',
    'Lengyelország' => 'Varsó',
];

function fovarosKereses(array $fovarosok, string $orszag): string
{
    if (array_key_exists($orszag, $fovarosok)) {
        return "$orszag fővárosa: {$fovarosok[$orszag]}";
    }
    return "Az ország nem található: $orszag";
}

// Tesztek
$keresesek = ['Románia', 'Németország', 'Ausztria'];

foreach ($keresesek as $orszag) {
    echo fovarosKereses($fovarosok, $orszag) . PHP_EOL;
}
