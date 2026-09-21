<?php

namespace App\Models;

class Order
{
    private array $items = [];

    public function __construct(public readonly string $orderId) {}

    public function addItem(string $product, int $qty): void
    {
        $this->items[] = ['product' => $product, 'qty' => $qty];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function __toString(): string
    {
        $lines = ["Rendelés #{$this->orderId}:"];
        foreach ($this->items as $item) {
            $lines[] = "  – {$item['product']} x{$item['qty']}";
        }
        return implode(PHP_EOL, $lines);
    }
}
