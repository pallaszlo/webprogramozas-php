<?php

// =============================================================
// 2.51. Paramétertípusok megadása
// =============================================================

declare(strict_types=1);

function add(int $a, int $b): int
{
    return $a + $b;
}

echo add(5, 3);  // Kimenet: 8
// echo add("5", "3");  // TypeError kivétel
