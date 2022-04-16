<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksSubjects */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="books-subjects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить тематику', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данную тематику?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a( 'Назад', '../books-subjects', ['class' => 'btn btn-warning']); ?>
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
