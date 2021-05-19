<?php

namespace App\validators;

abstract class AbstractValidator
{
    abstract function validate();
    abstract function getErrorMessage();
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}