<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */
/* @var $categories */
/* @var $subjects */

?>

<div class="books-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'subjects' => $subjects,
    ]) ?>

</div>
