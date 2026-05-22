<?php

require 'Product.php';

function checkout(string $productName, int $qty): void
{
    echo "Rendelés: {$productName} x{$qty}" . PHP_EOL;
    try {
        $product = Product::find($productName);
        $product->reduceStock($qty);
        $total = $product->getPrice() * $qty;
        printf("  Sikeres – összeg: %.2f RON, maradék készlet: %d db\n", $total, $product->getStock());
    } catch (ProductNotFoundException $e) {
        echo "  Hiba: " . $e->getMessage() . PHP_EOL;
    } catch (OutOfStockException $e) {
        echo "  Hiba: " . $e->getMessage() . PHP_EOL;
    } finally {
        echo "  → tranzakció lezárva" . PHP_EOL;
    }
    echo PHP_EOL;
}

// Katalógus feltöltése
new Product("Laptop",       4500.00, 3);
new Product("Okostelefon",  1200.00, 10);

checkout("Laptop",      2);   // sikeres
checkout("Laptop",      5);   // OutOfStockException
checkout("Tablet",      1);   // ProductNotFoundException
checkout("Okostelefon", 3);   // sikeres
