<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
/* @var $admins */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>

<script src="../../web/js/sha512.js"></script>
<div class="container-fluid col-xs-12">
    <div class="site-login container-fluid">
            <div style="text-align: center" class="col-xs-12">
                <img src="../../web/images/logo_sut.png" class="container col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4" alt="">
            </div>
            <div style="margin-top: 100px;">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [
                                'autocomplete' => 'off',
                        ],
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-sm-8 col-md-4\">{input}</div>\n<div class=\"col-sm-8 col-sm-offset-2 col-md-7 col-md-offset-4\">{error}</div>",
                            'labelOptions' => ['class' => 'col-sm-1 col-sm-offset-1 col-md-offset-3 control-label'],
                        ],
                        'class' => 'd-flex justify-content-center',


                    ]); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password', [
                        'inputOptions' => [
                            'id' => 'loginFormPassword',
                        ],
                        ])->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"col-sm-8 col-sm-offset-2 col-md-offset-4 col-md-4\">{input} {label}</div>\n<div class=\"col-md-8\">{error}</div>",
                        ]) ?>
                </div>
                <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-warning col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <div class="row" style="margin-top: 55px;">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 ">
                <div class="col-xs-10 text-left" style="padding: 0">
                    <span style="font-size: 14px">Или вы можете запросить аккаунт:</span s s>
                </div>
                <div class="col-xs-2 text-right" style="padding: 0;">
                    <?= Html::a('Перейти', ['/contact?subjectId=0'], ['class' => 'text-link']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $('#login-form').on('beforeSubmit', function () {
            var src = $("#loginFormPassword").val();
            var jsSha = new jsSHA(src);
            var hash = jsSha.getHash("SHA-512", "HEX");
            $("#loginFormPassword").val(hash);
            $('#login-form').submit( function () {
                $("#loginFormPassword").val(src);
                src = '';
            });
        });
</script>