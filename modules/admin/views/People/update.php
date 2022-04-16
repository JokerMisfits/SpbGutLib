<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */

$this->title = 'Update People: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Peoples', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
/* @var $depart */
?>
<div class="people-update">

    <?= $this->render('_form', [
        'model' => $model,
        'depart' => $depart,
    ]) ?>

</div>
