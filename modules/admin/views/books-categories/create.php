<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksCategories */

    $this->title = 'Добавить категорию';

?>

<style>body{margin-top: 50px;}</style>

<div class="books-categories-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
