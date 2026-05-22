<?php

// ============================================================
// 4. feladat – FizzBuzz (1–20)
// ============================================================

for ($i = 1; $i <= 20; $i++) {
    if ($i % 15 === 0) {
        echo "FizzBuzz";
    } elseif ($i % 3 === 0) {
        echo "Fizz";
    } elseif ($i % 5 === 0) {
        echo "Buzz";
    } else {
        echo $i;
    }
    echo PHP_EOL;
}
