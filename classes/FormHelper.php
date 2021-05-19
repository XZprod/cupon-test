<?php

namespace App;

use App\models\AbstractModel;

class FormHelper
{
    protected $model;

    public function __construct(AbstractModel $model)
    {
        $this->model = $model;
    }

    public function renderField($fieldName)
    {
        $label = $this->model->getLabels()[$fieldName];
        return "<div class='form-control'><div class='error'></div><input name='$fieldName' placeholder='{$label}'></div>";
    }
}