<?php

namespace App\models;

use App\models\AbstractModel;

/**
 * Class Review
 * @package App\models
 *
 * @property  int $id
 * @property string $name
 * @property string $email
 * @property string $message
 */
class Review extends AbstractModel
{
    public static function getTableName()
    {
        return "reviews";
    }

    public static function getLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'message' => 'Сообщение',
        ];
    }

    public static function rules()
    {
        return [
            'id' => 'primary',
            'name' => 'string',
            'email' => 'email',
            'message' => 'string',
        ];
    }

}