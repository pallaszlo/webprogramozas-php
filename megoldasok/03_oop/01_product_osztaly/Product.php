<?php

class Product
{
    private string $name;
    private float  $price;
    private int    $stock;

    public function __construct(string $name, float $price, int $stock)
    {
        $this->name  = $name;
        $this->setPrice($price);
        $this->setStock($stock);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException("Az ár nem lehet negatív.");
        }
        $this->price = $price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new InvalidArgumentException("A készlet nem lehet negatív.");
        }
        $this->stock = $stock;
    }

    public function __toString(): string
    {
        return sprintf(
            "%-20s | Ár: %8.2f RON | Készlet: %d db",
            $this->name,
            $this->price,
            $this->stock
        );
    }
}
