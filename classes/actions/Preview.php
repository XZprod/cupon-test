<?php

namespace App\actions;

use App\interfaces\ActionInterface;
use App\models\Review;

class Preview implements ActionInterface
{

    public function run($params)
    {

        $newReview = new Review();
        $newReview->load($_POST);

        $content = renderPartial('review-one', [
            'review' => $newReview,
        ]);

        return ['content' => $content];
    }

    public function getResponseType()
    {
        return 'json';
    }
}