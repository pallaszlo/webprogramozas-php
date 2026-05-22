<?php

// ============================================================
// 4. feladat – Leggyakrabban előforduló karakter
// ============================================================

function leggyakoribbKarakter(string $szoveg): array
{
    $szamlalo = [];

    for ($i = 0; $i < strlen($szoveg); $i++) {
        $karakter = $szoveg[$i];
        $szamlalo[$karakter] = ($szamlalo[$karakter] ?? 0) + 1;
    }

    $maxDb     = max($szamlalo);
    $karakter  = array_search($maxDb, $szamlalo);

    return ['karakter' => $karakter, 'darab' => $maxDb];
}

// Tesztek
$peldak = [
    "programming",
    "hello world",
    "aabbccddeeaaa",
];

foreach ($peldak as $pelda) {
    $eredmeny = leggyakoribbKarakter($pelda);
    printf(
        "%-20s → '%s' (%d alkalommal)\n",
        "\"$pelda\"",
        $eredmeny['karakter'],
        $eredmeny['darab']
    );
}
