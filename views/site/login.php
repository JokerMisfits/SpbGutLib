<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Авторизация';
?>
<script src="../../web/js/sha512.js"></script>
<div class="container-fluid col-xs-12">
    <div class="site-login container-fluid">
            <div class="col-md-offset-5 col-xs-offset-4">
                <img src="../../web/images/logo_sut.png" alt="" style="width: 180px">
            </div>
            <div class="col-lg-offset-4">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['autocomplete' => 'off'],
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-10 col-lg-offset-1\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
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
                            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        ]) ?>
                </div>
                <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-warning col-xs-12 col-lg-4 col-lg-offset-4', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

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