<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Department */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="departments-form">

    <?php $form = ActiveForm::begin([
        'id' => 'departments-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-lg-6 col-lg-offset-3 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',]); ?>

    <?= $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите название кафедры']) ?>

    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Url::to('/admin/departments'); ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>

