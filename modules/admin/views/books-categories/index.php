<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новую категорию', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['/admin/books-categories'], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="books-categories-index text-center">

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                Yii::$app->user->identity->access_level == 50 ? ([
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                ]
                ):(
                Yii::$app->user->identity->access_level == 100 ? (
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
