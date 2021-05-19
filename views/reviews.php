<?php

use App\FormHelper;

/**
 * @var \App\models\Review $newReview
 * @var \App\models\Review[] $reviews
 */
$formHelper = new FormHelper($newReview);

?>

<div class="row">
    <div class="col-md-6 offset-3">
        <h1>Отзывы</h1>
        Сортировать по <a href="/?sort=created_at">Дате</a> <a href="/?sort=name">Имени</a> <a href="/?sort=email">Email</a>
        <?php foreach ($reviews as $review):?>
            <?= renderPartial('review-one', ['review' => $review]) ?>
        <?php endforeach;?>
    </div>
    <div class="offset-md-3 col-md-3">
        <form action="/addreview" method="post" id="new-review">
            <h2>Оставьте отзыв</h2>
            <?= $formHelper->renderField('name') ?>
            <?= $formHelper->renderField('email') ?>
            <?= $formHelper->renderField('message') ?>
<!--            <div class="form-control-file">-->
<!--                <input type="file" name="file" id="file">-->
<!--            </div>-->
            <div class="form-control">
                <button id="preview">Просмотр</button>
                <input type="submit" value="Отправить">
            </div>
        </form>
    </div>
</div>