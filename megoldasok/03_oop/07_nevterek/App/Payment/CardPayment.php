<?php

namespace App\Payment;

class CardPayment extends Payment
{
    public function __construct(private float $limit) {}

    public function pay(float $amount): bool
    {
        if ($amount > $this->limit) {
            throw new \RuntimeException(
                "Kártyalimit ({$this->limit} RON) túllépve: {$amount} RON."
            );
        }
        echo "Kártyás fizetés: {$amount} RON. Sikeres." . PHP_EOL;
        return true;
    }

    public function getDescription(): string
    {
        return "Kártyás fizetés (limit: {$this->limit} RON)";
    }
}
