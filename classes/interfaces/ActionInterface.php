<?php

namespace App\interfaces;

interface ActionInterface
{
    public function run($params);
    public function getResponseType();
}