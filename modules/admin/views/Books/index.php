<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories app\modules\admin\models\BooksCategories */
/* @var $subjects app\modules\admin\models\BooksSubjects */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->identity->access_level >= 50){echo Html::a('Добавить новую книгу', ['create'], ['class' => 'btn btn-success']);} ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="books-index text-center">

    <?
    try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'author',
                'date',
                'keywords',
                'ISBN',
                'ISSN',
                'publisher',
                [
                    'attribute' => 'category_id',
                    'value' => function ($data){
                        return $data->category;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map($categories::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Категории']),
                ],
                [
                    'attribute' => 'subject_id',
                    'value' => function ($data){
                        return $data->subject;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', ArrayHelper::map($subjects::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Тематика']),
                ],
                Yii::$app->user->identity->access_level < 50 ? (
                [
                        'attribute' => 'stock',
                        'value' => function ($data){
                            if($data->stock == 1){
                                $options = ['class' => 'text-success'];
                                return Html::tag('span', Html::encode('Есть в наличии'), $options);
                            }
                            else{
                                $options = ['class' => 'text-danger'];
                                return Html::tag('span', Html::encode('Нет в наличии'), $options);
                            }
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'stock', [1 => 'Есть',0 => 'Нет'],['class'=>'form-control','prompt' => 'Все']),
                        'format' => 'raw',
                ]
                ) : (
                'count'
                ),
                Yii::$app->user->identity->access_level > 50 ? ('rest'):(''),
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);

    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
