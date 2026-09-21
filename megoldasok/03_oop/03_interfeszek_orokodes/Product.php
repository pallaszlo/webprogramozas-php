<?php

require_once 'Discountable.php';

class Product implements Discountable
{
    private float $price;
    private int   $stock;

    public function __construct(
        public readonly string $name,
        float $price,
        int   $stock
    ) {
        $this->setPrice($price);
        $this->setStock($stock);
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

    // Alapértelmezetten nincs kedvezmény (0%)
    public function getDiscount(): float
    {
        return 0.0;
    }

    // A kedvezményes ár. Minden termékre ugyanígy számítjuk, a kedvezmény
    // mértékét a getDiscount() adja, amelyet a leszármazott osztály felülírhat.
    public function getFinalPrice(): float
    {
        return $this->getPrice() * (1 - $this->getDiscount());
    }

    public function __toString(): string
    {
        return sprintf(
            "%s | Ár: %.2f RON | Kedvezmény: %.0f%%",
            $this->name,
            $this->price,
            $this->getDiscount() * 100
        );
    }
}
