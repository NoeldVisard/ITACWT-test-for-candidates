<?php

namespace App\PaymentProcessor;

use App\Constants;
use Exception;

class PaymentProcessorWrapper implements PaymentProcessorInterface
{
    private PaypalPaymentProcessor $paypalProcessor;
    private StripePaymentProcessor $stripeProcessor;

    /**
     * @param PaypalPaymentProcessor $paypalProcessor
     * @param StripePaymentProcessor $stripeProcessor
     */
    public function __construct(PaypalPaymentProcessor $paypalProcessor, StripePaymentProcessor $stripeProcessor)
    {
        $this->paypalProcessor = $paypalProcessor;
        $this->stripeProcessor = $stripeProcessor;
    }

    public function processPayment(float|int $price, $paymentProcessor): bool|string
    {
        switch ($paymentProcessor) {
            case Constants::PAYMENT_PROCESSOR_PAYPAL:
                try {
                    $this->paypalProcessor->pay($price);
                } catch (Exception $exception) {
                    return $exception->getMessage();
                }

                return true;
            case Constants::PAYMENT_PROCESSOR_STRIPE:
                return $this->stripeProcessor->processPayment($price);
            default:
                return 'Process payment failed';
        }
    }
}