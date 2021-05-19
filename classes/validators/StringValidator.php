<?php

namespace App\validators;

class StringValidator extends AbstractValidator
{
    public function validate()
    {
        return is_string($this->value) && strlen(trim($this->value)) > 0;
    }

    function getErrorMessage()
    {
        return 'Значение должно быть непустой строкой';
    }
}