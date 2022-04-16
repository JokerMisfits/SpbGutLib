<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksSubjects */

$this->title = 'Добавить тематику';
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="books-subjects-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
