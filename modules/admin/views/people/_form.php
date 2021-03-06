<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */
/* @var $form yii\widgets\ActiveForm */
/* @var $depart */

?>

<style>body{margin-top: 50px;}</style>

<div class="people-form">

    <?php $form = ActiveForm::begin([
        'id' => 'accounts-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-lg-6 col-lg-offset-3 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',
    ]); ?>

    <!--  FORM FOR CREATE  -->
    <?php
    if(Yii::$app->controller->action->id == 'create' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
        echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
     echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
     echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
     echo $form->field($model, 'pass_number',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['placeholder' => 'Введите номер пропуска/удостоверения']);
        echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart,['prompt' => 'Выберите кафедру']);
    }
    ?>
    <!--  FORM FOR CREATE END  -->

    <!--  FORM FOR UPDATE  -->
    <?php
    if(Yii::$app->controller->action->id == 'update' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
        echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
        echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
        echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
        echo $form->field($model, 'comment',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 2, 'placeholder' => 'Введите комментарий']);
        echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart,['prompt' => 'Выберите кафедру']);

    }

    ?>
    <!--  FROM FOR UPDATE END  -->

    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Url::to('/admin/people'); ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>
