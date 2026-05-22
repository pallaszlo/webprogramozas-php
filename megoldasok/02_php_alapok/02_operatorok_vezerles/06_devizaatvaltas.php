<?php

// ============================================================
// 6. feladat – Devizaátváltási táblázat (RON → EUR, USD, GBP)
// ============================================================

const EUR_ARFOLYAM = 5.0;   // 1 EUR = 5.0 RON
const USD_ARFOLYAM = 4.5;   // 1 USD = 4.5 RON
const GBP_ARFOLYAM = 5.8;   // 1 GBP = 5.8 RON

// Fejléc
printf("%-10s %10s %10s %10s\n", "RON", "EUR", "USD", "GBP");
printf("%s\n", str_repeat("-", 44));

// Sorok: 100-tól 1000-ig, 100-as lépésekben
for ($ron = 100; $ron <= 1000; $ron += 100) {
    printf(
        "%-10d %10.2f %10.2f %10.2f\n",
        $ron,
        $ron / EUR_ARFOLYAM,
        $ron / USD_ARFOLYAM,
        $ron / GBP_ARFOLYAM
    );
}
