<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories */
/* @var $subjects */
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="books-form">

    <?php $form = ActiveForm::begin([
        'id' => 'books-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-lg-6 col-lg-offset-3 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',
    ]); ?>

    <!--  FORM FOR CREATE AND UPDATE  -->

    <?
    if((Yii::$app->controller->action->id == 'create' || Yii::$app->controller->action->id == 'update') && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
        echo $form->field($model, 'name',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 1]);
        echo $form->field($model, 'author',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 2]);
        echo $form->field($model, 'date',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true,'placeholder' => 'Введите год первой публикации без пробелов']);
        echo $form->field($model, 'keywords',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 3]);
        echo $form->field($model, 'ISBN',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true]);
        echo $form->field($model, 'ISSN',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true]);
        echo $form->field($model, 'publisher',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true]);
        echo $form->field($model, 'publish_date',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['maxlength' => true,'placeholder' => 'Введите год издания без пробелов']);
        echo $form->field($model, 'category_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($categories,['prompt' => 'Выберите категорию']);
        echo $form->field($model, 'subject_id',['enableAjaxValidation' => true, 'enableClientValidation' => false])->dropDownList($subjects,['prompt' => 'Выберите тематику']);
        echo $form->field($model, 'annotation',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 5]);
        echo $form->field($model, 'comment',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textarea(['rows' => 2]);
        if(Yii::$app->controller->action->id == 'create'){
            echo $form->field($model, 'count',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['placeholder' => 'Значение должно быть строго положительным!', 'value' => 1]);
        }
        elseif(Yii::$app->controller->action->id == 'update'){
            echo $form->field($model, 'count',['enableAjaxValidation' => true, 'enableClientValidation' => false])->textInput(['placeholder' => 'Изменение этого параметра без учета книг которые еще не вернули, может все сломать!']);
        }
    }
    ?>

    <!--  FORM FOR CREATE AND UPDATE END  -->

    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Url::to('/admin/books'); ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>