<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $subjects */
/* @var $selected */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';
?>
<div class="site-contact">
    <h1 class="text-center"><?= Html::encode($this->title).' <span class="text-danger text" style="font-size: 22px;font-weight: bolder" title="Оформление и функционал могут быть изменены">Beta</span>' ?></h1>

    <?php
    if(Yii::$app->session->hasFlash('contactFormSubmitted')){
        echo '<div class="alert alert-success">';
        echo 'Благодарим вас за обращение.' . '<br>' . 'Мы ответим вам как можно скорее.' . '<br>';
        echo Html::a('Назад', '/', ['class' => 'btn btn-primary']);
        echo '</div>';
    }
    else{
        echo '<div class="row">';
        echo '<div class="col-md-6 col-md-offset-3">';
        $form = ActiveForm::begin(['id' => 'contact-form']);
        echo $form->field($model, 'name')->textInput(['placeholder' => 'Введите ваше ФИО']);
        echo $form->field($model, 'email')->textInput(['placeholder' => 'Введите ваш Email']);
        if(isset($selected) && $selected == 0){
            echo $form->field($model, 'subject')->dropDownList($subjects,['value' => 0, 'disabled' => true]);
            echo $form->field($model, 'subject')->hiddenInput(['value' => 0])->label(false);
        }
        elseif(isset($selected) && $selected == 1){
            echo $form->field($model, 'subject')->dropDownList($subjects,['value' => 1, 'disabled' => true]);
            echo $form->field($model, 'subject')->hiddenInput(['value' => 1])->label(false);
        }
        else{
            echo $form->field($model, 'subject')->dropDownList($subjects,['prompt' => 'Выберите причину обращения']);
        }
        echo $form->field($model, 'body')->textarea(['rows' => 9,'placeholder' => 'Для получения аккаунта:
Введите ваш номер пропуска\удостоверения;
Введите вашу кафедру;
Аккаунт будет выслан вам на почту.

Если вы заметили ошибку-неисправность:
Опишите проблему максимально подробно;
Мы с ней обязательно разберемся!']);
        echo $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-xs-4 col-sm-3">{image}</div><div class="col-xs-8 col-sm-9">{input}</div></div>',
                        'options' => ['placeholder' => 'Можно обновить проверочный код, нажав на картинку.'],
            ]);
        echo '<div class="form-group">';
        echo Html::submitButton('Отправить', ['class' => 'btn btn-primary col-xs-12', 'name' => 'contact-button']);
        echo '</div>';
        ActiveForm::end();
        echo '</div>';
        echo '</div>';
    }
    ?>


</div>
