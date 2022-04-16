<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить книгу', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данную книгу?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a( 'Назад', '../books', ['class' => 'btn btn-warning']); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name:ntext',
            'author:ntext',
            'date',
            'keywords:ntext',
            'ISBN',
            'ISSN',
            'publisher',
            'publish_date',
            [
                'attribute' => 'category_id',
                'value' => function ($data){
                    return $data->category;
                }
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($data){
                    return $data->subject;
                }
            ],
            'annotation:ntext',
            'count',
            'rest',
            [
                'attribute' => 'stock',
                'value' => function ($data){
                    if($data->stock == 1){
                        $options = ['style' => ['color' => 'green']];
                        return Html::tag('span', Html::encode('Есть в наличии'), $options);
                    }
                    else{
                        $options = ['style' => ['color' => 'red']];
                        return Html::tag('span', Html::encode('Нет в наличии'), $options);
                    }
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
