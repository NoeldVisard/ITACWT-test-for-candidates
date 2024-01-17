<?php

namespace App\Service;

use App\Validator\CalculatePriceValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataValidationService
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateData(array $data)
    {
        $constraints = CalculatePriceValidator::getConstraints();

        $violations = $this->validator->validate($data, new Assert\Collection($constraints));

        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }

}