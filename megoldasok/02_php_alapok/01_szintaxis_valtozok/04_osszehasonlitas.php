<?php

// ============================================================
// 4. feladat – == és === operátor összehasonlítása
// ============================================================

$parok = [
    [0,    false],
    ["1",  true],
    [null, 0],
    ["42", 42],
    ["",   false],
];

$cimkek = [
    "0    és false",
    '"1"  és true',
    "null és 0",
    '"42" és 42',
    '"" és false',
];

echo str_pad("Pár", 18) . str_pad("==", 8) . "===" . PHP_EOL;
echo str_repeat("-", 35) . PHP_EOL;

foreach ($parok as $index => $par) {
    [$a, $b] = $par;
    $laza    = ($a == $b)  ? "igaz" : "hamis";
    $szigoru = ($a === $b) ? "igaz" : "hamis";
    echo str_pad($cimkek[$index], 18) . str_pad($laza, 8) . $szigoru . PHP_EOL;
}
