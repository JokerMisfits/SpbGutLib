<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access app\modules\admin\models\AccessLevel */
/* @var $department app\modules\admin\models\Department */
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$this->title = 'Аккаунты';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новый аккаунт', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="accounts-index text-center">

    <?php
    try{
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'name',
            'surname',
            'middle_name',
            'pass_number',
            [
            'attribute' => 'parent_id',
                'value' => function ($data) {
                    return Html::a(Html::encode('Ссылка пользователя'), Url::to(['people/', 'PeopleSearch[id]' => $data->parent]));
                },
                'filter' => false,
                'format' => 'raw',
            ],
            [
                'attribute' => 'department_id',
                'value' => function ($data){
                    return $data->depart;
                },
                'filter' => Html::activeDropDownList($searchModel, 'department_id', ArrayHelper::map($department::find()->select('name,id')->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Выберете кафедру']),
            ],
            [
                'attribute' => 'access_level',
                'value' => function ($data){
                    return $data->access;
                },
                'filter' => Html::activeDropDownList($searchModel, 'access_level', ArrayHelper::map($access::find()->select('access_name,access_level')->asArray()->all(), 'access_level', 'access_name'),['class'=>'form-control','prompt' => 'Выберете уровень доступа']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    }
    catch (Exception|Throwable $exception){
            Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
