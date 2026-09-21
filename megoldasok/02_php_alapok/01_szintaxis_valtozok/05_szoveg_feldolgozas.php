<?php

// ============================================================
// 5. feladat – Szövegfeldolgozás beépített sztringfüggvényekkel
// ============================================================

$mondat = "Ez egy tesztmondat 42 számmal és admin@example.ro e-mail-címmel.";

// 1. Karakterek száma szóközök nélkül
// (az mb_strlen() karaktereket számol, a strlen() az ékezetes betűket két bájtnak venné)
$szokozNelkul = str_replace(" ", "", $mondat);
$hossz        = mb_strlen($szokozNelkul);
echo "Karakterszám szóközök nélkül: $hossz" . PHP_EOL;

// 2. Csupa kisbetű (a strtolower() az ékezetes nagybetűket nem alakítaná át)
$kisbetus = mb_strtolower($mondat);
echo "Kisbetűsen: $kisbetus" . PHP_EOL;

// 3. Számjegyek cseréje '#'-re
$szamokNelkul = preg_replace('/[0-9]/', '#', $mondat);
echo "Számjegyek helyett #: $szamokNelkul" . PHP_EOL;

// 4. '@' karakter megléte
if (strpos($mondat, "@") !== false) {
    echo "A mondat tartalmaz '@' karaktert." . PHP_EOL;
} else {
    echo "A mondat nem tartalmaz '@' karaktert." . PHP_EOL;
}
