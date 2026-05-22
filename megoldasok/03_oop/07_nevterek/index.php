<?php

require 'autoloader.php';

use App\Models\Product;
use App\Models\Order;
use App\Payment\CashPayment;
use App\Payment\CardPayment;

// Termékek
$laptop = new Product("Laptop", 4500.00, 10);
$phone  = new Product("Okostelefon", 1200.00, 25);

echo $laptop . PHP_EOL;
echo $phone  . PHP_EOL;
echo PHP_EOL;

// Rendelés
$order = new Order("ORD-001");
$order->addItem("Laptop", 1);
$order->addItem("Okostelefon", 2);
echo $order . PHP_EOL;
echo PHP_EOL;

// Fizetés
function checkout(\App\Payment\Payment $payment, float $total): void
{
    echo "Fizetési mód: " . $payment->getDescription() . PHP_EOL;
    try {
        $payment->pay($total);
    } catch (RuntimeException $e) {
        echo "Hiba: " . $e->getMessage() . PHP_EOL;
    }
}

checkout(new CashPayment(), 6900.00);
checkout(new CardPayment(5000.00), 6900.00);
checkout(new CardPayment(8000.00), 6900.00);
