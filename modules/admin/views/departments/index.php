<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\DepartmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Кафедры';

?>

<style>body{margin-top: 50px;}</style>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить новую кафедру', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['/admin/departments'], ['class' => 'btn btn-primary']) ?>
    </p>
<div class="department-index text-center">

    <?php
    try {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}<br>{delete}'
            ],
        ],
    ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
