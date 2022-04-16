<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */

$this->title = $model->surname . ' ' . $model->name . ' ' . $model->middle_name;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="accounts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить аккаунт', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данный аккаунт?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a( 'Назад', '../accounts', ['class' => 'btn btn-warning']); ?>
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
            ],
        ]);
    }
    catch (Exception|Throwable $exception){
        Yii::$app->session->setFlash('error',$exception->getMessage());
    }?>

</div>
