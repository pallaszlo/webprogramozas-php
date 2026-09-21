<?php

// ============================================================
// 6. feladat – TODO-lista szimuláció
// ============================================================

function feladatHozzaad(array &$lista, string $cim): void
{
    $lista[] = ['cim' => $cim, 'kesz' => false];
}

function feladatTorol(array &$lista, int $index): void
{
    if (array_key_exists($index, $lista)) {
        unset($lista[$index]);
    }
}

function feladatKesznek(array &$lista, int $index): void
{
    if (array_key_exists($index, $lista)) {
        $lista[$index]['kesz'] = true;
    }
}

function feladatokListaz(array $lista): void
{
    if (empty($lista)) {
        echo "  (üres lista)" . PHP_EOL;
        return;
    }
    foreach ($lista as $index => $feladat) {
        $allapot = $feladat['kesz'] ? '[KÉSZ]  ' : '[FOLYAMATBAN]';
        echo "  $allapot #$index: {$feladat['cim']}" . PHP_EOL;
    }
}

// --- Szimuláció ---

$lista = [];

feladatHozzaad($lista, "PHP alapok átnézése");
feladatHozzaad($lista, "Feladatok megírása");
feladatHozzaad($lista, "Kód tesztelése");
feladatHozzaad($lista, "Dokumentáció frissítése");

echo "Kezdeti lista:" . PHP_EOL;
feladatokListaz($lista);

feladatKesznek($lista, 0);
feladatKesznek($lista, 2);

echo PHP_EOL . "Két feladat teljesítése után:" . PHP_EOL;
feladatokListaz($lista);

feladatTorol($lista, 3);

echo PHP_EOL . "Törlés után:" . PHP_EOL;
feladatokListaz($lista);
