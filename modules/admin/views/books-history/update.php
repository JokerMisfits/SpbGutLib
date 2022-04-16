<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksHistory */
/* @var $books */
/* @var $people */
?>

<div class="books-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'books' => $books,
        'people' => $people,
    ]) ?>

</div>
