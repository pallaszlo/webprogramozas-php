<?php

// =============================================================
// 2.69. Típusdeklaráció variadic függvénynél
// =============================================================

declare(strict_types=1);

function sumIntegers(int ...$numbers)
{
    return array_sum($numbers);
}

echo sumIntegers(1, 2, 3);  // Működik
// echo sumIntegers(1, 2, '3');
// TypeError: Argument 3 must be of type int, string given
