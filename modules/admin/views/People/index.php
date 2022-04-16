<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PeopleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access app\modules\admin\models\AccessLevel */
/* @var $department app\modules\admin\models\Department */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить нового пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="people-index text-center">

    <?php
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'surname',
                'name',
                'middle_name',
                'pass_number',
                [
                    'attribute' => 'books',
                    'value' => function ($data) {
                        if($data->books == null){
                            return null;
                        }
                        else{
                            return Html::a(Html::encode('Список книг'), Url::to(['books-history/', 'BooksHistorySearch[user_id]' => $data->id,'BooksHistorySearch[active]' => 1]));
                        }
                    },
                    'filter' => false,
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'child_id',
                    'value' => function ($data) {
                        if($data->child == null){
                            return null;
                        }
                        else{
                            return Html::a(Html::encode('Ссылка аккаунта'), Url::to(['accounts/', 'AccountsSearch[id]' => $data->child]));
                        }
                    },
                    'filter' => false,
                    'format' => 'raw',
                ],
                'comment',
                [
                    'attribute' => 'department_id',
                    'value' => function ($data){
                        return $data->depart;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'department_id', ArrayHelper::map($department::find()->select('name,id')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Выберете кафедру']),
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
