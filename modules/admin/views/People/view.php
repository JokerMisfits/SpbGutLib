<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */

$this->title = $model->surname . ' ' . $model->name . ' ' . $model->middle_name;
$this->params['breadcrumbs'][] = ['label' => 'Peoples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="people-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить пользователя', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данного пользователя?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a( 'Назад', '../people', ['class' => 'btn btn-warning']); ?>
    </p>

    <?
    try {
      echo  DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'surname',
                'middle_name',
                'comment:ntext',
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
    catch (Exception $exception){
        return Yii::$app->getSession()->setFlash('error', $exception);
    }
 ?>

</div>
