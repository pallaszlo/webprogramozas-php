<?php

require_once 'Payment.php';

class CardPayment extends Payment
{
    public function __construct(private float $limit) {}

    public function pay(float $amount): bool
    {
        if ($amount > $this->limit) {
            throw new RuntimeException(
                "A kártyás fizetési keret ({$this->limit} RON) nem elegendő a(z) {$amount} RON-os tranzakcióhoz."
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
