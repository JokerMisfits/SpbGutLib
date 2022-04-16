<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Department */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="department-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Удалить кафедру', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить данную кафедру?',
                    'method' => 'post',
                ],
            ]);
            echo Html::a( 'Назад', '/admin/departments', ['class' => 'btn btn-warning']);
        ?>
    </p>

    <?php
    try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
