<?php

require 'ProductStatus.php';
require 'Order.php';

// --- ProductStatus backed enum ---------------------------------

echo "=== Termék státuszok ===" . PHP_EOL;
foreach (ProductStatus::cases() as $case) {
    printf("  %-14s → %s\n", $case->value, $case->label());
}

$status = ProductStatus::from('active');
echo PHP_EOL . "Lekért státusz: " . $status->label() . PHP_EOL;

// --- OrderStatus unit enum + Order osztály --------------------

echo PHP_EOL . "=== Rendelés életciklusa ===" . PHP_EOL;
$order = new Order("ORD-2024-001");
$order->setStatus(OrderStatus::Processing);
$order->setStatus(OrderStatus::Shipped);
$order->setStatus(OrderStatus::Delivered);

echo PHP_EOL . "Végső státusz: " . $order->getStatus()->name . PHP_EOL;
