<?php

// ============================================================
// 7. feladat – Bankszámla-szimuláció
// ============================================================

$egyenleg = 500.0;

// Előre megadott tranzakciók (pozitív = befizetés, negatív = kifizetés)
$tranzakciok = [150.0, -200.0, 300.0, -100.0, -700.0, 50.0];

echo sprintf("Kezdeti egyenleg: %.2f RON", $egyenleg) . PHP_EOL;
echo str_repeat("-", 40) . PHP_EOL;

foreach ($tranzakciok as $osszeg) {
    $ujEgyenleg = $egyenleg + $osszeg;

    if ($ujEgyenleg < 0) {
        echo sprintf(
            "Sikertelen: %.2f RON kifizetés – nincs elegendő fedezet.",
            abs($osszeg)
        ) . PHP_EOL;
        break;
    }

    $tipus     = $osszeg > 0 ? "Befizetés " : "Kifizetés ";
    $egyenleg  = $ujEgyenleg;

    echo sprintf("%s %+.2f RON → Egyenleg: %.2f RON", $tipus, $osszeg, $egyenleg) . PHP_EOL;
}

echo str_repeat("-", 40) . PHP_EOL;
echo sprintf("Záró egyenleg: %.2f RON", $egyenleg) . PHP_EOL;
