<?php

namespace App\actions;

use App\interfaces\ActionInterface;
use App\models\Review;

class Addreview implements ActionInterface
{

    public function run($params)
    {

        $newReview = new Review();
        $newReview->load($_POST);

        if (!$newReview->validate()) {
            return [
                'status' => 'error',
                'errors' => $newReview->getErrors(),
            ];
        }
        if ($newReview->save()) {
            return 'Запись успешно добавлена';
        }
        return 'error';
    }

    public function getResponseType()
    {
        return 'json';
    }
}