<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksSubjects */
?>

<style>
    .books-subjects-update{
        margin-top: 50px;
    }
</style>

<div class="books-subjects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
