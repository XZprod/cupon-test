<?php

namespace App\actions;

use App\interfaces\ActionInterface;
use App\models\Review;

class Reviews implements ActionInterface
{

    public function run($params)
    {
        $newReview = new Review();
        $sort = 'created_at';
        if (isset($params['sort'])) {
            $sort = $params['sort'];
        }
        Review::orderBy($sort);

        $reviews = Review::findAll();
        $content = renderPartial('reviews', [
            'newReview' => $newReview,
            'reviews' => $reviews,
        ]);

        return $content;
    }

    public function getResponseType()
    {
        return 'html';
    }
}