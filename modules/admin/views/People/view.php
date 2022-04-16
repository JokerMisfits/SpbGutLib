<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */

$this->title = $model->surname . ' ' . $model->name . ' ' . $model->middle_name;
\yii\web\YiiAsset::register($this);
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="people-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if((isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))){
                if(Yii::$app->user->identity->access_level == 50){
                    if(Yii::$app->user->identity->id == $model->child_id){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                    elseif(Yii::$app->user->identity->access_level > $model->access_level){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                }
                elseif(Yii::$app->user->identity->access_level == 100){
                    if(Yii::$app->user->identity->id == $model->child_id){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                    else{
                        if(Yii::$app->user->identity->access_level > $model->access_level){
                            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            echo Html::a('Удалить пользователя', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить данного пользователя?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    }
                }
            }
            echo Html::a( 'Назад', '/admin/people', ['class' => 'btn btn-warning']);
        ?>
    </p>

    <?php
    try {
      echo  DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'surname',
                'middle_name',
                'comment',
                'books',
                'pass_number',
                [
                    'attribute' => 'access_level',
                    'value' => function ($data){
                        return $data->depart;
                    },
                ],
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
