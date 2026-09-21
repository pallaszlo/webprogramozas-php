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

// A főváros neve, vagy null, ha az ország nem szerepel a tömbben
function fovarosKereses(array $fovarosok, string $orszag): ?string
{
    return $fovarosok[$orszag] ?? null;
}

// Tesztek
$keresesek = ['Románia', 'Németország', 'Ausztria'];

foreach ($keresesek as $orszag) {
    $fovaros = fovarosKereses($fovarosok, $orszag);
    if ($fovaros !== null) {
        echo "$orszag fővárosa: $fovaros" . PHP_EOL;
    } else {
        echo "Hiba: az ország nem található: $orszag" . PHP_EOL;
    }
}
