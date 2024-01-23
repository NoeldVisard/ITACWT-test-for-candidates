<?php

namespace App\Service;

use App\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

class DataValidationService
{
    private $validator;

    public function __construct(SymfonyValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateData(array $data, ValidatorInterface $customValidator)
    {
        $constraints = $customValidator::getConstraints();

        $violations = $this->validator->validate($data, new Assert\Collection($constraints));

        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }

}