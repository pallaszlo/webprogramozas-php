<?php

// ============================================================
// 2. feladat – Érdemjegy meghatározása match kifejezéssel
// ============================================================

$pontszam = 78;

$erdemJegy = match(true) {
    $pontszam >= 90 => "jeles",
    $pontszam >= 75 => "jó",
    $pontszam >= 60 => "közepes",
    $pontszam >= 50 => "elégséges",
    default         => "elégtelen",
};

echo "Pontszám:   $pontszam" . PHP_EOL;
echo "Érdemjegy:  $erdemJegy" . PHP_EOL;
