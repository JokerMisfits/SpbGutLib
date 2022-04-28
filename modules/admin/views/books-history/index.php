<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $book app\modules\admin\models\Books */
/* @var $active app\modules\admin\models\BooksHistory */
/* @var $count */

    $this->title = 'Заявки';

    $access = 0;
    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
    }

?>

<style>body{margin-top: 50px;}</style>

    <h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Добавить новую запись', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Сбросить поиск', ['/admin/books-history'], ['class' => 'btn btn-primary']) ?>
    <?php
        if($access >= 100 && $count > 0){
            echo Html::a('Удалить неактивные заявки', ['active'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Данное действие приведет к удалению ' .$count. ' записей, вы уверены?',
                    'method' => 'post',
                ],
            ]);
        }
    ?>
</p>

<div class="books-history-index text-center">

    <?php
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'book_id',
                    'value' => function ($data){
                        return $data->book;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'book_id', ArrayHelper::map($book::find()->select('name,id')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Выберете книгу']),
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function ($data) {
                        return Html::a(Html::encode('Ссылка пользователя'), Url::to(['people/', 'PeopleSearch[id]' => $data->user_id]));
                    },
                    'filter' => false,
                    'format' => 'raw',
                ],
                'date_from',
                'date_end',
                'comment',
                'count',
                [
                    'attribute' => 'active',
                    'value' => function ($data){
                        if($data->active == 1){
                            $options = ['style' => ['color' => 'green']];
                            return Html::a(Html::encode('Закрыть заявку'),Url::to(['books-history/close', 'id' => $data->id]), $options);
                        }
                        else{
                            $options = ['style' => ['color' => 'red']];
                            return Html::tag('span', Html::encode('Неактивна'), $options);
                        }
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'active', [1 => 'Активные',0 => 'Неактивные'],['class'=>'form-control','prompt' => 'Все заявки']),
                    'format' => 'raw',
                ],

                $access == 50 ? ([
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}<br>{update}',
                ]
                ):(
                $access == 100 ? (
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}<br>{update}<br>{delete}'
                ]):('')
                ),
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
