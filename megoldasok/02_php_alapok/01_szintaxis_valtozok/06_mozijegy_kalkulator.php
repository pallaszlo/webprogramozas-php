<?php

// ============================================================
// 6. feladat – Mozijegy-kalkulátor
// ============================================================

const ALAPAR         = 35;   // RON
const HETVEGI_FELAAR = 8;    // RON
const KEDV_GYEREK    = 0.40; // 14 év alatt
const KEDV_NYUGDIJAS = 0.30; // 65 év felett
const KEDV_DIAK      = 0.20; // diákigazolvánnyal

// Néző adatai
$kor     = 17;
$hetvege = true;
$diak    = true;

// Alapár + hétvégi felár
$jegyAr = ALAPAR;
if ($hetvege) {
    $jegyAr += HETVEGI_FELAAR;
}

// Kedvezmény meghatározása (csak a legnagyobb érvényesül)
$kedvezmeny = 0.0;

if ($kor < 14) {
    $kedvezmeny = KEDV_GYEREK;
} elseif ($kor > 65) {
    $kedvezmeny = KEDV_NYUGDIJAS;
} elseif ($diak) {
    $kedvezmeny = KEDV_DIAK;
}

$fizetendo = $jegyAr * (1 - $kedvezmeny);

// Kimenet
echo "Kor: $kor év" . PHP_EOL;
echo "Hétvége: " . ($hetvege ? "igen" : "nem") . PHP_EOL;
echo "Diák: "    . ($diak    ? "igen" : "nem") . PHP_EOL;
echo "Alapár + hétvégi felár: $jegyAr RON" . PHP_EOL;
echo "Kedvezmény: " . ($kedvezmeny * 100) . "%" . PHP_EOL;
echo sprintf("Fizetendő: %.2f RON", $fizetendo) . PHP_EOL;
