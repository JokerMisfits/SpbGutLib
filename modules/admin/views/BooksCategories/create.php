<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\BooksCategories */

$this->title = 'Create Books Categories';
$this->params['breadcrumbs'][] = ['label' => 'Books Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
