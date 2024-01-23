<?php

namespace App\Validator;

interface ValidatorInterface
{
    public static function getConstraints(): array;
}