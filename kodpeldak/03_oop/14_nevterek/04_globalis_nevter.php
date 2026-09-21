<?php

// =============================================================
// 3.58. Globális névtér elérése
// =============================================================

namespace MyProject;

$array    = \array_filter([1, null, 3]);  // beépített függvény
$datetime = new \DateTime();              // beépített osztály

// Saját strlen, amely elfedi a beépített függvényt
function strlen(string $str): string
{
    return 'Egyéni strlen megvalósítás';
}

echo \strlen('Hello');  // 5 (beépített függvény)
echo strlen('Hello');   // Egyéni strlen megvalósítás
