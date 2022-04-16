<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */
/* @var $category */
/* @var $subject */

$this->title = 'Добавить книгу';
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="books-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $category,
        'subjects' => $subject,
    ]) ?>

</div>
