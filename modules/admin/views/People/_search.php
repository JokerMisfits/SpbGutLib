<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\PeopleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="people-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'surname') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'access_level') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'books') ?>

    <?php // echo $form->field($model, 'child_id') ?>

    <?php // echo $form->field($model, 'pass_number') ?>

    <?php // echo $form->field($model, 'department_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
