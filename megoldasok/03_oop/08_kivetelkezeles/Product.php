<?php

require_once 'ProductNotFoundException.php';
require_once 'OutOfStockException.php';

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

    /**
     * Termék keresése név alapján a katalógusban (név => Product tömb).
     * Ha nincs ilyen termék, ProductNotFoundException kivételt dob.
     */
    public static function find(array $catalog, string $name): self
    {
        if (!isset($catalog[$name])) {
            throw new ProductNotFoundException($name);
        }
        return $catalog[$name];
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    /** Ellenőrzi a készletet. Ha nem elegendő, OutOfStockException kivételt dob. */
    public function checkStock(int $qty): void
    {
        if ($qty > $this->stock) {
            throw new OutOfStockException($this->name, $qty, $this->stock);
        }
    }

    /** Csökkenti a készletet. Nem elegendő készlet esetén OutOfStockException kivételt dob. */
    public function reduceStock(int $qty): void
    {
        $this->checkStock($qty);
        $this->stock -= $qty;
    }

    public function __toString(): string
    {
        return sprintf("%s | %.2f RON | %d db", $this->name, $this->price, $this->stock);
    }
}
