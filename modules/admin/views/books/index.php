<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories app\modules\admin\models\BooksCategories */
/* @var $subjects app\modules\admin\models\BooksSubjects */

    $this->title = 'Книги';

    $access = 0;
    $template = '{view}';

    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
        if($access == 50){
            $template = '{view}<br>{update}';
        }
        elseif($access == 100){
            $template = '{view}<br>{update}<br>{delete}';
        }
    }

?>

<style>
    body{
        margin-top: 50px;
    }
</style>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($access >= 50){echo Html::a('Добавить новую книгу', ['create'], ['class' => 'btn btn-success']);} ?>
        <?= Html::a('Сбросить поиск', ['/admin/books'], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="books-index text-center">

    <?php

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
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map($categories::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Выберете категорию']),
                ],
                [
                    'attribute' => 'subject_id',
                    'value' => function ($data){
                        return $data->subject;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', ArrayHelper::map($subjects::find()->select('name,id')->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Выберете тематику']),
                ],
                $access < 50 ? (
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
                $access >= 50 ? ([
                    'attribute' => 'rest',
                    'value' => function ($data){
                        return $data->rest;
                    },
                ]
                ):([
                    'attribute' => 'rest',
                    'value' => function ($data){
                        return $data->rest;
                    },
                    'visible' => false,
                ]),

                $access <= 50 ? ([
                    'class' => 'yii\grid\ActionColumn',
                    'template' => $template,
                ]
                ):(
                $access == 100 ? (
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => $template,
                ]):([
                    'attribute' => 'rest',
                    'value' => function ($data){
                        return $data->rest;
                    },
                    'visible' => false,
                ])
                ),
            ],
        ]);

    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error', $exception->getMessage());
    }?>


</div>
