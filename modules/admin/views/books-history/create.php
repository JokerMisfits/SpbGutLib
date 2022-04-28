<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksHistory */
/* @var $books */
/* @var $people */

    $this->title = 'Добавить запись';

?>

<style>body{margin-top: 50px;}</style>

<div class="books-history-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'books' => $books,
        'people' => $people,
    ]) ?>

</div>
