<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */
/* @var $depart */
/* @var $level */
/* @var $form yii\widgets\ActiveForm */

?>

<style>
    body{
        margin-top: 50px;
    }
    @media(max-width: 1200px) {
        #reveal-password{
            padding: 0;
            margin-top: 0;
            margin-bottom: 15px;
        }
    }
</style>

<script src="../../../../web/js/sha512.js"></script>
<div class="accounts-form" >

    <?php

    $form = ActiveForm::begin([
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
    if(Yii::$app->controller->action->id == 'create' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 100))){
        $this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#accounts-password').attr('type',this.checked?'text':'password');})");
        echo $form->field($model, 'username',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите логин']);
        echo $form->field($model, 'password',['enableAjaxValidation' => true, 'enableClientValidation' => false,'selectors' =>
            ['id' => '#accounts-password']])->passwordInput(['maxlength' => false, 'placeholder' => 'Введите пароль']);
        echo $form->field($model, 'password_confirm',['enableAjaxValidation' => true, 'enableClientValidation' => false,'selectors' =>
            ['id' => '#accounts-password-confirm']])->passwordInput(['maxlength' => false, 'placeholder' => 'Повторите пароль']);
        echo '<div class="col-lg-6 col-lg-offset-3">';
        echo Html::checkbox('reveal-password', false, ['id' => 'reveal-password']);
        echo Html::label("&nbsp".' Показать пароль', 'reveal-password');
        echo '</div>';
        echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
        echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
        echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
        echo $form->field($model, 'pass_number',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер пропуска/удостоверения']);
        echo $form->field($model, 'email',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите email']);
        echo $form->field($model, 'phone',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона']);
        echo $form->field($model, 'access_level',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($level,['prompt' => 'Выберите уровень доступа']);
        echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart,['prompt' => 'Выберите кафедру']);
    }
    ?>

<!--  FORM FOR CREATE END  -->

<!--  FORM FOR UPDATE  -->
    <?php
        if(Yii::$app->controller->action->id == 'update' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))){
            if(Yii::$app->user->identity->access_level == 50){
                if(Yii::$app->user->identity->id == $model->id){
                    echo $form->field($model, 'email',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите email']);
                    echo $form->field($model, 'phone',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона']);
                    echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart);
                }
                else{
                    echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
                    echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
                    echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
                    echo $form->field($model, 'email',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите email']);
                    echo $form->field($model, 'phone',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона']);
                    echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart);
                }
            }
            elseif(Yii::$app->user->identity->access_level == 100){
                if(Yii::$app->user->identity->id == $model->id){
                    echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
                    echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
                    echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
                    echo $form->field($model, 'email',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите email']);
                    echo $form->field($model, 'phone',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона']);
                    echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart);
                }
                else{
                    echo $form->field($model, 'surname',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите фамилию']);
                    echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите имя']);
                    echo $form->field($model, 'middle_name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите отчество']);
                    echo $form->field($model, 'email',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите email']);
                    echo $form->field($model, 'phone',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона']);
                    echo $form->field($model, 'department_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($depart);
                    echo $form->field($model, 'access_level',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($level);
                }
            }
        }
    ?>
<!-- FORM FOR UPDATE END -->
    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Url::to('/admin/accounts'); ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>


<script>
    $('#accounts-form').on('beforeSubmit', function () {
        if($('#accounts-password').val() != null){
            let src = $('#accounts-password').val();
            let jsSha = new jsSHA(src);
            let hash = jsSha.getHash("SHA-512", "HEX");
            $('#accounts-password').val(hash);
            src = $('#accounts-password_confirm').val();
            jsSha = new jsSHA(src);
            hash = jsSha.getHash("SHA-512", "HEX");
            $('#accounts-password_confirm').val(hash);
            $('#accounts-form').submit( function () {
                $('#accounts-password').val(src);
                $('#accounts-password_confirm').val(src);
                src = '';
            });
        }
        else{
            return true;
        }
    });
</script>