<?php

namespace App\Models;

class Product
{
    private float $price;
    private int   $stock;

    public function __construct(
        public readonly string $name,
        float $price,
        int   $stock
    ) {
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getPrice(): float { return $this->price; }
    public function getStock(): int   { return $this->stock; }

    public function __toString(): string
    {
        return sprintf("%-20s | %8.2f RON | %d db", $this->name, $this->price, $this->stock);
    }
}
