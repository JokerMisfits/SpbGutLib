<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */
/* @var $form yii\widgets\ActiveForm */
/* @var $category */
/* @var $subject */
?>
<div class="books-form">

    <?php $form = ActiveForm::begin([
        'id' => 'books-form',
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-offset-3 \"> {label}</div>\n<div class=\"col-lg-6 col-lg-offset-3\">{input}</div>\n<div class=\"col-xs-12 col-lg-3 col-lg-offset-5 \">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
        'class' => 'd-flex justify-content-center',
    ]); ?>

    <!--  FORM FOR CREATE  -->

    <?
    if(Yii::$app->controller->action->id == 'create' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
        echo $form->field($model, 'name')->textarea(['rows' => 1]);
        echo $form->field($model, 'author')->textarea(['rows' => 3]);
        echo $form->field($model, 'deadline')->widget(\yii\jui\DatePicker::className(), ['options' => ['class' => 'form-control'],]);
        echo $form->field($model, 'keywords')->textarea(['rows' => 6]);
        echo $form->field($model, 'ISBN')->textInput(['maxlength' => true]);
        echo $form->field($model, 'ISSN')->textInput(['maxlength' => true]);
        echo $form->field($model, 'publisher')->textInput(['maxlength' => true]);
        echo $form->field($model, 'publish_date')->textInput(['maxlength' => true]);
        echo $form->field($model, 'category_id')->dropDownList($category,['prompt' => 'Выберите категорию']);
        echo $form->field($model, 'subject_id')->dropDownList($subject,['prompt' => 'Выберите тематику']);
        echo $form->field($model, 'count')->textInput(['placeholder' => 'Значение должно быть строго положительным!']);
    }
    ?>

    <!--  FORM FOR CREATE END  -->

    <!--  FORM FOR UPDATE  -->

    <?
    if(Yii::$app->controller->action->id == 'update' && (isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))) {
        echo $form->field($model, 'name')->textarea(['rows' => 1]);
        echo $form->field($model, 'author')->textarea(['rows' => 3]);
        echo $form->field($model, 'date')->textInput(['maxlength' => true]);
        echo $form->field($model, 'keywords')->textarea(['rows' => 6]);
        echo $form->field($model, 'ISBN')->textInput(['maxlength' => true]);
        echo $form->field($model, 'ISSN')->textInput(['maxlength' => true]);
        echo $form->field($model, 'publisher')->textInput(['maxlength' => true]);
        echo $form->field($model, 'publish_date')->textInput(['maxlength' => true]);
        echo $form->field($model, 'category_id')->dropDownList($category,['prompt' => 'Выберите категорию']);
        echo $form->field($model, 'subject_id')->dropDownList($subject,['prompt' => 'Выберите тематику']);
        echo $form->field($model, 'count')->textInput(['placeholder' => 'Изменение этого параметра без учета книг которые еще не вернули, может все сломать!']);
    }
    ?>

    <!--  FROM FOR UPDATE END  -->
    <div class="form-group col-xs-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-xs-12 col-lg-6 col-lg-offset-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-12">
        <a href="<?= Yii::$app->request->referrer ?>"><button class="btn btn-danger col-xs-12 col-lg-6 col-lg-offset-3">Назад</button></a>
    </div>
</div>