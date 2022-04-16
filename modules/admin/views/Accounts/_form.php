<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */
/* @var $depart */
/* @var $level */
/* @var $form yii\widgets\ActiveForm */

?>
<script src="../../../../web/js/sha512.js"></script>
<div class="accounts-form" >

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
    if(Yii::$app->controller->action->id == 'create' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level == 100))){
        echo $form->field($model, 'username')->textInput(['maxlength' => true]);
        echo $form->field($model, 'password',['selectors' =>
            ['id' => '#accounts-password']])->passwordInput(['maxlength' => false]);
        echo $form->field($model, 'name')->textInput(['maxlength' => true]);
        echo $form->field($model, 'surname')->textInput(['maxlength' => true]);
        echo $form->field($model, 'middle_name')->textInput(['maxlength' => true]);
        echo $form->field($model, 'pass_number')->textInput(['maxlength' => true]);
        echo $form->field($model, 'email')->textInput(['maxlength' => true]);
        if(isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 100)){
            echo $form->field($model, 'access_level')->dropDownList($level,['prompt' => 'Выберите уровень доступа']);
        }
        echo $form->field($model, 'department_id')->dropDownList($depart,['prompt' => 'Выберите кафедру']);
    }
    ?>

<!--  FORM FOR CREATE END  -->

<!--  FORM FOR UPDATE  -->
    <?php
        if(Yii::$app->controller->action->id == 'update' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level == 100))){
            echo $form->field($model, 'name')->textInput(['maxlength' => true]);
            echo $form->field($model, 'surname')->textInput(['maxlength' => true]);
            echo $form->field($model, 'middle_name')->textInput(['maxlength' => true]);
            echo $form->field($model, 'email')->textInput(['maxlength' => true]);
            echo $form->field($model, 'department_id')->dropDownList($depart);
            if(isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 100)){
                echo $form->field($model, 'access_level')->dropDownList($level);
            }
        }

    ?>
<!-- FORM FOR UPDATE END -->
    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Yii::$app->request->referrer ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>


</div>

<script>
    $('#accounts-form').on('beforeSubmit', function () {
        if($("#accounts-password").val() != null){
            var src = $("#accounts-password").val();
            var jsSha = new jsSHA(src);
            var hash = jsSha.getHash("SHA-512", "HEX");
            $("#accounts-password").val(hash);
            $('#accounts-form').submit( function () {
                $("#accounts-password").val(src);
                src = '';
            });
        }
        else{
            return true;
        }
    });
</script>