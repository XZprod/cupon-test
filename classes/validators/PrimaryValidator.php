<?php

namespace App\validators;

class PrimaryValidator extends AbstractValidator
{
    public function validate()
    {
        return true;
    }

    function getErrorMessage()
    {
        return '';
    }
}