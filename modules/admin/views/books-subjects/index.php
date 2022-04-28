<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksSubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Тематики';

    $access = 0;
    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
    }

?>

<style>body{margin-top: 50px;}</style>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить новую тематику', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['/admin/books-subjects'], ['class' => 'btn btn-primary']) ?>
    </p>
<div class="books-subjects-index text-center">

    <?php
    try {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            $access == 50 ? ([
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ]
            ):(
            $access == 100 ? (
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}<br>{delete}'
            ]):('')
            ),
        ],
    ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>