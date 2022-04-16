<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\PeopleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access app\modules\admin\models\AccessLevel */
/* @var $department app\modules\admin\models\Department */
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="people-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить нового пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'surname',
                'middle_name',
                'pass_number',
                'books',
                [
                    'attribute' => 'child_id',
                    'value' => function ($data) {
                        return Html::a(Html::encode('Ссылка аккаунта'), Url::to(['accounts/', 'AccountsSearch[id]' => $data->child]));
                    },
                    'format' => 'raw',
                ],
                'comment:ntext',
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
    catch (Exception $exception){
        if(isset($exception->errorInfo[0]) && $exception->errorInfo[0] != null){
            $error = $exception->errorInfo[0].'<br>';
            $error .= $exception->errorInfo[1].'<br>';
            $error .= $exception->errorInfo[2].'<br>';
            $url = Url::to(['./people']);
            $error .= "<a href='$url'>Назад</a>";
            Yii::$app->session->setFlash('error', "Поиск в данном поле возможен ввод только латиницей.<br> $error");
        }
        else{
            echo '<pre>';
            exit(var_dump($exception));
        }
    }?>


</div>
