<?php

// ============================================================
// 4. feladat – Leggyakrabban előforduló karakter
// ============================================================

function leggyakoribbKarakter(string $szoveg): array
{
    $szamlalo = [];

    // Az mb_str_split() karakterekre bont. A $szoveg[$i] bájtot adna vissza,
    // ami az ékezetes betűknél hibás eredményt okozna.
    foreach (mb_str_split($szoveg) as $karakter) {
        $szamlalo[$karakter] = ($szamlalo[$karakter] ?? 0) + 1;
    }

    $maxDb    = max($szamlalo);
    $karakter = array_search($maxDb, $szamlalo);

    return ['karakter' => $karakter, 'darab' => $maxDb];
}

// Tesztek
$peldak = [
    "barackpálinka",
    "élet és remény",
    "aabbccddeeaaa",
];

foreach ($peldak as $pelda) {
    $eredmeny = leggyakoribbKarakter($pelda);
    echo "\"$pelda\" → '{$eredmeny['karakter']}' ({$eredmeny['darab']} alkalommal)" . PHP_EOL;
}
