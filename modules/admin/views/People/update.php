<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\people */

$this->title = 'Изменить пользователя: ' . $model->name;
/* @var $depart */
?>

<div class="people-update">

    <?= $this->render('_form', [
        'model' => $model,
        'depart' => $depart,
    ]) ?>

</div>
