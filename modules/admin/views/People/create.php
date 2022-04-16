<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */

$this->title = 'Создание пользователя';
/* @var $depart */
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="people-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'depart' => $depart,
    ]) ?>

</div>
