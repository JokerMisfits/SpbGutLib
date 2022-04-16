<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */
/* @var $form yii\widgets\ActiveForm */
/* @var $depart */
?>

<div class="people-form">

    <?php $form = ActiveForm::begin([
        'id' => 'accounts-form',
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-xs-12 col-lg-3 col-lg-offset-5 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',
    ]); ?>

    <!--  FORM FOR CREATE  -->
    <?php
    if(Yii::$app->controller->action->id == 'create' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
     echo $form->field($model, 'name')->textInput(['maxlength' => true]);
     echo $form->field($model, 'surname')->textInput(['maxlength' => true]);
     echo $form->field($model, 'middle_name')->textInput(['maxlength' => true]);
     echo $form->field($model, 'pass_number')->textInput();
        echo $form->field($model, 'department_id')->dropDownList($depart,['prompt' => 'Выберите кафедру']);
    }
    ?>
    <!--  FORM FOR CREATE END  -->

    <!--  FORM FOR UPDATE  -->
    <?php
    if(Yii::$app->controller->action->id == 'update' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {

        echo $form->field($model, 'name')->textInput(['maxlength' => true]);
        echo $form->field($model, 'surname')->textInput(['maxlength' => true]);
        echo $form->field($model, 'middle_name')->textInput(['maxlength' => true]);
        echo $form->field($model, 'comment')->textarea(['rows' => 3]);
        echo $form->field($model, 'department_id')->dropDownList($depart,['prompt' => 'Выберите кафедру']);

    }

    ?>
    <!--  FROM FOR UPDATE END  -->

    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
