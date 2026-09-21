<?php

namespace App\Payment;

class CashPayment extends Payment
{
    public function pay(float $amount): bool
    {
        echo "Készpénzes fizetés: {$amount} RON. Sikeres." . PHP_EOL;
        return true;
    }

    public function getDescription(): string
    {
        return "Készpénzes fizetés";
    }
}
