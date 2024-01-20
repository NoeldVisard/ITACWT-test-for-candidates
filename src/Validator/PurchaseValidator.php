<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseValidator
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
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
                new Assert\Regex([
                    'pattern' => '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Za-z]{2}\d{9})$/',
                    'message' => 'Invalid couponCode format.',
                ]),
            ],
            'paymentProcessor' => [
                new Assert\NotBlank(),
                new Assert\Regex([

                ]),
            ],
        ];
    }
}
