<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category app\modules\admin\models\BooksCategories */
/* @var $subject app\modules\admin\models\BooksSubjects */
use yii\helpers\ArrayHelper;
$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новую книгу', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name:ntext',
                'author:ntext',
                'date',
                'keywords:ntext',
                'ISBN',
                'ISSN',
                'publisher',
                //'publish_date',
                [
                    'attribute' => 'category_id',
                    'value' => function ($data){
                        return $data->category;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map($category::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Категории']),
                ],
                [
                    'attribute' => 'subject_id',
                    'value' => function ($data){
                        return $data->subject;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', ArrayHelper::map($subject::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Тематика']),
                ],
                //'annotation:ntext',
                'count',
                'rest',
                //'stock',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    }
    catch (Exception $exception){
        if(isset($exception->errorInfo[0]) && $exception->errorInfo[0] != null){
            $error = $exception->errorInfo[0].'<br>';
            $error .= $exception->errorInfo[1].'<br>';
            $error .= $exception->errorInfo[2].'<br>';
            $url = Url::to(['./accounts']);
            $error .= "<a href='$url'>Назад</a>";
            Yii::$app->session->setFlash('error', "Поиск в данном поле возможен только латиницей.<br> $error");
        }
        else{
            echo '<pre>';
            exit(var_dump($exception));
        }
    }
 ?>


</div>
