<?php

require 'ElectronicsProduct.php';

$book    = new Product("PHP kézikönyv", 80.00, 50);
$laptop  = new ElectronicsProduct("Laptop", 4500.00, 10, 24);
$phone   = new ElectronicsProduct("Okostelefon", 1200.00, 25, 12);

$products = [$book, $laptop, $phone];

// A printf() a szöveg hosszát bájtokban számolja, nem karakterekben.
// Ezért az ékezetes szövegeket karakterszám alapján egészítjük ki szóközökkel.
function kitolt(string $szoveg, int $szelesseg): string
{
    return $szoveg . str_repeat(' ', max(0, $szelesseg - mb_strlen($szoveg)));
}

echo kitolt("Termék", 20) . " | " . kitolt("Ár (RON)", 10) . " | "
    . kitolt("Kedvezmény", 10) . " | Végár (RON)" . PHP_EOL;
echo str_repeat("-", 62) . PHP_EOL;

// Polimorfizmus: mindkét osztályon ugyanazokat a metódusokat hívjuk,
// a kedvezmény mértékét az adott objektum osztálya határozza meg.
foreach ($products as $product) {
    printf(
        "%s | %10.2f | %9.0f%% | %10.2f\n",
        kitolt($product->name, 20),
        $product->getPrice(),
        $product->getDiscount() * 100,
        $product->getFinalPrice()
    );
}

echo PHP_EOL;

// A __toString() a leszármazott osztályban a garanciával bővül
foreach ($products as $product) {
    echo $product . PHP_EOL;
}
