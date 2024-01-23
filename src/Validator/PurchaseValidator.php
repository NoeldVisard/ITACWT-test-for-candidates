<?php

namespace App\Validator;

use App\Constants;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseValidator implements ValidatorInterface
{
    public static function getConstraints(): array
    {
        return [
            'product' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'integer']),
                new Assert\Positive(),
            ],
            'taxNumber' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
                new Assert\Regex([
                    'pattern' => '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Za-z]{2}\d{9})$/',
                    'message' => 'Invalid taxNumber format.',
                ]),
            ],
            'couponCode' => [
                new Assert\Optional([
                    new Assert\Regex([
                        'pattern' => '/^D(I)?\d+$/',
                        'message' => 'Invalid couponCode format. It should be "DX" or "DIX" where X is any number.'
                    ])
                ])
            ],
            'paymentProcessor' => [
                new Assert\NotBlank(),
                new Assert\Choice([
                    Constants::PAYMENT_PROCESSOR_STRIPE,
                    Constants::PAYMENT_PROCESSOR_PAYPAL
                ]),
            ],
        ];
    }
}
