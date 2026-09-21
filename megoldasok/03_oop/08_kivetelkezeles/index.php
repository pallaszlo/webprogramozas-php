<?php

require 'Product.php';
require 'CashPayment.php';
require 'CardPayment.php';

// A 4. feladat checkout() függvénye, kiegészítve a termék keresésével,
// a készlet ellenőrzésével és try/catch/finally kivételkezeléssel
function checkout(Payment $payment, array $catalog, string $productName, int $qty): void
{
    echo "Rendelés: {$productName} x{$qty} – " . $payment->getDescription() . PHP_EOL;
    try {
        $product = Product::find($catalog, $productName);
        $product->checkStock($qty);         // fizetés előtt ellenőrizzük a készletet

        $total = $product->getPrice() * $qty;
        $payment->pay($total);
        $product->reduceStock($qty);        // csak sikeres fizetés után csökken a készlet

        printf("  Sikeres rendelés – maradék készlet: %d db\n", $product->getStock());
    } catch (ProductNotFoundException | OutOfStockException $e) {
        // A két saját kivételt egy catch blokkban kezeljük
        echo "  Rendelési hiba: " . $e->getMessage() . PHP_EOL;
    } catch (RuntimeException $e) {
        // A kártyás fizetés keret túllépésekor dobott kivétel
        echo "  Fizetési hiba: " . $e->getMessage() . PHP_EOL;
    } finally {
        echo "  → tranzakció lezárva" . PHP_EOL;
    }
    echo PHP_EOL;
}

// Katalógus: terméknév => Product
$catalog = [
    'Laptop'      => new Product("Laptop", 4500.00, 3),
    'Okostelefon' => new Product("Okostelefon", 1200.00, 10),
];

$cash = new CashPayment();
$card = new CardPayment(5000.0);

checkout($cash, $catalog, "Laptop", 2);        // sikeres
checkout($cash, $catalog, "Laptop", 5);        // OutOfStockException
checkout($cash, $catalog, "Tablet", 1);        // ProductNotFoundException
checkout($card, $catalog, "Okostelefon", 5);   // túllépett kártyakeret (6000 RON)
checkout($card, $catalog, "Okostelefon", 3);   // sikeres
