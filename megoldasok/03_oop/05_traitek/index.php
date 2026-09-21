<?php

require 'Product.php';
require 'Order.php';

echo "=== Termék ===" . PHP_EOL;
$laptop = new Product("Laptop", 4500.00, 10);
$laptop->setPrice(4200.00);
$laptop->setStock(8);

echo PHP_EOL . "Létrehozva: " . $laptop->getCreatedAt() . PHP_EOL;
echo "Utolsó módosítás: "     . $laptop->getUpdatedAt() . PHP_EOL;

echo PHP_EOL . "=== Rendelés ===" . PHP_EOL;
$order = new Order("ORD-001");
$order->addItem("Laptop", 1);
$order->addItem("Egér", 2);

echo PHP_EOL . "Rendelés tételei:" . PHP_EOL;
foreach ($order->getItems() as $item) {
    echo "  – {$item['product']} x{$item['qty']}" . PHP_EOL;
}
