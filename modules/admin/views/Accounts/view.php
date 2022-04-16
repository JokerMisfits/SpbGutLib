<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */

$this->title = $model->surname . ' ' . $model->name . ' ' . $model->middle_name;
\yii\web\YiiAsset::register($this);
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="accounts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if((isset(Yii::$app->user->identity->access_level) && (Yii::$app->user->identity->access_level >= 50))){
                if(Yii::$app->user->identity->access_level == 50){
                    if(Yii::$app->user->identity->id == $model->id){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                    elseif(Yii::$app->user->identity->access_level > $model->access_level){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                }
                elseif(Yii::$app->user->identity->access_level == 100){
                    if(Yii::$app->user->identity->id == $model->id){
                        echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                    else{
                        if(Yii::$app->user->identity->access_level > $model->access_level){
                            echo Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            echo Html::a('Удалить аккаунт', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить данный аккаунт?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    }
                }
            }
            echo Html::a( 'Назад', '/admin/accounts', ['class' => 'btn btn-warning']);

        ?>
    </p>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'name',
                'surname',
                'middle_name',
                'pass_number',
                'email',
                'phone',
                [
                    'attribute' => 'department_id',
                    'value' => function ($data){
                        return $data->depart;
                    }
                ],
                [
                    'attribute' => 'access_level',
                    'value' => function ($data){
                        return $data->access;
                    }
                ],
                [
                    'attribute' => 'registration_timestamp',
                    'value' => function($data){ return date("d.m.Y H:i:s",$data->registration_timestamp);},
                ],
                [
                    'attribute' => 'last_activity_timestamp',
                    'value' => function($data){
                        $timestamp = time();
                        $last_activity = $data->last_activity_timestamp;
                        if($last_activity == null){
                            return "<b class='text-danger'>Offline</b>";
                        }
                        $difference = $timestamp -$last_activity;
                        if($difference <= 900){
                            return "<b class='text-success'>Online</b>";
                        }
                        return "<b class='text-danger'>Offline</b> с " . date("d.m.Y H:i:s",$data->last_activity_timestamp);
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
