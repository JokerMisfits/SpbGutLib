<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Books */
/* @var $category */
/* @var $subject */

?>
<div class="books-update">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'subject' => $subject,
    ]) ?>

</div>
