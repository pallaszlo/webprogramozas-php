<?php

require_once 'Loggable.php';
require_once 'Timestampable.php';

class Order
{
    use Loggable, Timestampable;

    private array $items = [];

    public function __construct(public readonly string $orderId)
    {
        $this->initTimestamps();
        $this->log("Rendelés létrehozva: #{$orderId}");
    }

    public function addItem(string $product, int $qty): void
    {
        $this->items[] = ['product' => $product, 'qty' => $qty];
        $this->touch();
        $this->log("Tétel hozzáadva: {$product} x{$qty}");
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
