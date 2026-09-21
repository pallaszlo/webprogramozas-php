<?php

// =============================================================
// 2.56. A szigorú mód használata
// =============================================================

declare(strict_types=1);

function add(int $a, int $b): int
{
    return $a + $b;
}

echo add(5, 3);  // Működik
// echo add("5", "3");  // TypeError kivétel
