<?php

require_once 'OrderStatus.php';
require_once 'Loggable.php';

class Order
{
    use Loggable;

    private OrderStatus $status;

    public function __construct(public readonly string $orderId)
    {
        $this->status = OrderStatus::Pending;
        $this->log("Rendelés létrehozva – státusz: {$this->status->name}");
    }

    public function setStatus(OrderStatus $status): void
    {
        $prev = $this->status->name;
        $this->status = $status;
        $this->log("Státusz módosítva: {$prev} → {$this->status->name}");
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}
