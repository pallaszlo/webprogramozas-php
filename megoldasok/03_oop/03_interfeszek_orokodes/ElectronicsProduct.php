<?php

require_once 'Product.php';

class ElectronicsProduct extends Product
{
    // A szülő konstruktorát egy új adattal, a garancia hosszával bővítjük
    public function __construct(
        string $name,
        float $price,
        int $stock,
        private int $warrantyMonths
    ) {
        parent::__construct($name, $price, $stock);
    }

    public function getWarrantyMonths(): int
    {
        return $this->warrantyMonths;
    }

    // 15%-os kedvezmény. A getFinalPrice() a szülőosztályból öröklődik,
    // és ezt a kedvezményt használja a kedvezményes ár kiszámításához.
    public function getDiscount(): float
    {
        return 0.15;
    }

    public function __toString(): string
    {
        return parent::__toString() . " | Garancia: {$this->warrantyMonths} hónap";
    }
}
