<?php

// =============================================================
// 2.37. A do...while ciklus használata
// =============================================================

$pin = "";

do {
    $pin = readline("Adja meg a PIN kódot: ");

    if ($pin != "1234") {
        echo "Helytelen PIN. Próbálja újra.\n";
    }

} while ($pin != "1234");

echo "Sikeres bejelentkezés!";
// Kimenet: a felhasználói bevitel függvényében változó
