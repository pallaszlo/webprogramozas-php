<?php

require_once 'ProductNotFoundException.php';
require_once 'OutOfStockException.php';

class Product
{
    private static array $catalog = [];

    private float $price;
    private int   $stock;

    public function __construct(
        public readonly string $name,
        float $price,
        int   $stock
    ) {
        $this->price = $price;
        $this->stock = $stock;
        self::$catalog[$name] = $this;
    }

    public static function find(string $name): self
    {
        if (!isset(self::$catalog[$name])) {
            throw new ProductNotFoundException($name);
        }
        return self::$catalog[$name];
    }

    public function getPrice(): float { return $this->price; }
    public function getStock(): int   { return $this->stock; }

    public function reduceStock(int $qty): void
    {
        if ($qty > $this->stock) {
            throw new OutOfStockException($this->name, $qty, $this->stock);
        }
        $this->stock -= $qty;
    }

    public function __toString(): string
    {
        return sprintf("%-20s | %8.2f RON | %d db", $this->name, $this->price, $this->stock);
    }
}
