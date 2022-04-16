<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */
/* @var $depart */
/* @var $level */

$this->title = 'Регистрация пользователя';
?>

<style>
    body{
        margin-top: 50px;
    }
</style>

<div class="accounts-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'model' => $model,
            'depart' => $depart,
            'level' => $level,
        ])
    ?>

</div>
