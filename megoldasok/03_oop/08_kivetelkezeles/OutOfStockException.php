<?php

class OutOfStockException extends RuntimeException
{
    public function __construct(string $productName, int $requested, int $available)
    {
        parent::__construct(
            "Nincs elegendő készlet a(z) \"{$productName}\" termékből: "
            . "{$requested} db kérve, {$available} db elérhető."
        );
    }
}
