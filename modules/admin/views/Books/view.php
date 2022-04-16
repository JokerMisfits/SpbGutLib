<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

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

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'author',
                'date',
                'keywords',
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
                            $options = ['class' => 'text-success'];
                            return Html::tag('span', Html::encode('Есть в наличии'), $options);
                        }
                        else{
                            $options = ['class' => 'text-danger'];
                            return Html::tag('span', Html::encode('Нет в наличии'), $options);
                        }
                    },
                    'format' => 'raw',
                ],
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
