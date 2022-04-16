<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksHistory */

$this->title = 'Create Books History';
$this->params['breadcrumbs'][] = ['label' => 'Books Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
