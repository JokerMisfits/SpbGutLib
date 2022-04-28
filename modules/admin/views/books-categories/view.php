<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksCategories */

    $this->title = $model->name;

    yii\web\YiiAsset::register($this);

    $access = 0;
    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
    }

?>

<style>body{margin-top: 50px;}</style>

<div class="books-categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(Yii::$app->user->identity->access_level == 50){
            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        elseif(Yii::$app->user->identity->access_level == 100){
            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a('Удалить категорию', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить данную категорию?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?= Html::a( 'Назад', '/admin/books-categories', ['class' => 'btn btn-warning']); ?>
    </p>

    <?php try{
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
