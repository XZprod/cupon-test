<?php

namespace App\validators;

class EmailValidator extends AbstractValidator
{
    public function validate()
    {
        return preg_match('/[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-zA-Z0-9]+/', $this->value);
    }

    function getErrorMessage()
    {
        return 'Некорректный email';
    }
}