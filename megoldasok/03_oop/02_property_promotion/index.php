<?php

require 'Product.php';

$original = new Product("Laptop", 4500.00, 10);
$clone    = clone $original;

$clone->setPrice(3900.00);
$clone->setStock(5);

echo "Eredeti:" . PHP_EOL;
echo $original . PHP_EOL;

echo PHP_EOL . "Klón (nullázott készlettel, majd frissítve):" . PHP_EOL;
echo $clone . PHP_EOL;

// A readonly tulajdonság nem módosítható klónon sem
// $clone->name = "Akciós laptop";  // Fatal error: readonly property
