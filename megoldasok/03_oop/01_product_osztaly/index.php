<?php

require 'Product.php';

$laptop = new Product("Laptop", 4500.00, 10);
$phone  = new Product("Okostelefon", 1200.00, 25);

echo $laptop . PHP_EOL;
echo $phone  . PHP_EOL;

echo PHP_EOL;

$laptop->setPrice(4200.00);
echo "Módosított ár után:" . PHP_EOL;
echo $laptop . PHP_EOL;

// Negatív ár kísérlete
try {
    $phone->setPrice(-100.0);
} catch (InvalidArgumentException $e) {
    echo "Hiba: " . $e->getMessage() . PHP_EOL;
}
