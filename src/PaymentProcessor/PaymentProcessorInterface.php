<?php

namespace App\PaymentProcessor;

interface PaymentProcessorInterface
{
    /**
     * @param float|int $price payment amount
     * @return bool|string true if payment was succeeded, array of errors otherwise
     */
    public function processPayment(float|int $price, string $paymentProcessor): bool|string;
}