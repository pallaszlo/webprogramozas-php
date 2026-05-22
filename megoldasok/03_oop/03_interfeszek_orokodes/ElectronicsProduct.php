<?php

require_once 'Product.php';

class ElectronicsProduct extends Product
{
    public function __construct(string $name, float $price, int $stock)
    {
        parent::__construct($name, $price, $stock);
    }

    public function getDiscount(): float
    {
        return 0.15;
    }

    public function getFinalPrice(): float
    {
        return $this->getPrice() * (1 - $this->getDiscount());
    }
}
