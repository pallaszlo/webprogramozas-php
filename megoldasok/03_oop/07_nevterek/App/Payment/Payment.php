<?php

namespace App\Payment;

abstract class Payment
{
    abstract public function pay(float $amount): bool;

    public function getDescription(): string
    {
        return static::class . " fizetési mód";
    }
}
