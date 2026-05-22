<?php

require_once 'Loggable.php';
require_once 'Timestampable.php';

class Product
{
    use Loggable, Timestampable;

    private float $price;
    private int   $stock;

    public function __construct(
        public readonly string $name,
        float $price,
        int   $stock
    ) {
        $this->price = $price;
        $this->stock = $stock;
        $this->initTimestamps();
        $this->log("Termék létrehozva: {$this->name}");
    }

    public function getPrice(): float { return $this->price; }

    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException("Az ár nem lehet negatív.");
        }
        $this->price = $price;
        $this->touch();
        $this->log("Ár módosítva: {$price} RON");
    }

    public function getStock(): int { return $this->stock; }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new InvalidArgumentException("A készlet nem lehet negatív.");
        }
        $this->stock = $stock;
        $this->touch();
        $this->log("Készlet módosítva: {$stock} db");
    }
}
