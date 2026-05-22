<?php

require 'ElectronicsProduct.php';

$book    = new Product("PHP kézikönyv", 80.00, 50);
$laptop  = new ElectronicsProduct("Laptop", 4500.00, 10);
$phone   = new ElectronicsProduct("Okostelefon", 1200.00, 25);

$products = [$book, $laptop, $phone];

printf("%-20s | %10s | %10s | %10s\n", "Termék", "Ár (RON)", "Kedvezmény", "Végár (RON)");
echo str_repeat("-", 60) . PHP_EOL;

foreach ($products as $product) {
    $finalPrice = $product instanceof ElectronicsProduct
        ? $product->getFinalPrice()
        : $product->getPrice();

    printf(
        "%-20s | %10.2f | %9.0f%% | %10.2f\n",
        $product->name,
        $product->getPrice(),
        $product->getDiscount() * 100,
        $finalPrice
    );
}
