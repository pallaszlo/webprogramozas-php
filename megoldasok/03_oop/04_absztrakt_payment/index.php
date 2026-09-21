<?php

require 'CashPayment.php';
require 'CardPayment.php';

function checkout(Payment $payment, float $total): void
{
    echo "Fizetési mód: " . $payment->getDescription() . PHP_EOL;
    try {
        $success = $payment->pay($total);
        if ($success) {
            echo "Rendelés sikeresen teljesítve." . PHP_EOL;
        }
    } catch (RuntimeException $e) {
        echo "Fizetési hiba: " . $e->getMessage() . PHP_EOL;
    }
    echo PHP_EOL;
}

$cash     = new CashPayment();
$card500  = new CardPayment(500.0);
$card2000 = new CardPayment(2000.0);

checkout($cash,     320.00);   // sikeres készpénz
checkout($card500,  320.00);   // sikeres kártya
checkout($card500,  750.00);   // túllépett keret
checkout($card2000, 750.00);   // sikeres kártya
