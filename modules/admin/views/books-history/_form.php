<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksHistory */
/* @var $books */
/* @var $people */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="books-history-form">

    <?php $form = ActiveForm::begin([
        'id' => 'books-history-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-lg-6 col-lg-offset-3 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',
    ]); ?>

    <!--  FORM FOR CREATE AND UPDATE  -->

    <?php
    if((Yii::$app->controller->action->id == 'create' || Yii::$app->controller->action->id == 'update') && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))){
        if(Yii::$app->controller->action->id == 'create'){
            echo $form->field($model, 'book_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($books,['prompt' => 'Для поиска начните набирать название'])->label('Книга');
            echo $form->field($model, 'user_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($people,['prompt' => 'Для поиска начните набирать ФИО'])->label('Пользователь');
        }
        echo $form->field($model, 'comment',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 2, 'placeholder' => 'Введите комментарий']);
        if(Yii::$app->controller->action->id == 'create'){
            echo $form->field($model, 'count',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['placeholder' => 'Введите количество книг', 'value' => 1]);
        }
    }
    ?>

    <!--  FORM FOR CREATE AND UPDATE END  -->


    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Url::to('/admin/books-history'); ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>
