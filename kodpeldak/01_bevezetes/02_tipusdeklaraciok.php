<?php

// =============================================================
// 1.8. Típusdeklarációk használata
// =============================================================

declare(strict_types=1);

// Paraméter és visszatérési típus
function add(int $a, int $b): int
{
    return $a + $b;
}

// Nullable típus: null is visszaadható
function findUser(int $id): ?string
{
    if ($id === 1) {
        return "Admin";
    }
    return null;
}

// Union type (PHP 8.0+)
function formatPrice(int|float $price): string
{
    return number_format($price, 2) . " RON";
}


// Kiegészítés (nem szerepel a könyvben): a függvények használata
echo add(2, 3) . "\n";                        // 5
echo (findUser(1) ?? "nincs ilyen") . "\n";   // Admin
echo (findUser(2) ?? "nincs ilyen") . "\n";   // nincs ilyen
echo formatPrice(1250) . "\n";                // 1,250.00 RON
echo formatPrice(19.9) . "\n";                // 19.90 RON

// A strict_types miatt a "5" sztring nem alakul át automatikusan egész számmá
try {
    echo add("5", 3) . "\n";
} catch (TypeError $e) {
    echo "TypeError: " . explode(', called in', $e->getMessage())[0] . "\n";
    // TypeError: add(): Argument #1 ($a) must be of type int, string given
}
