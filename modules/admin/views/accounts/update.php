<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Accounts */
/* @var $depart */
/* @var $level */

?>
<script src="../../../../web/js/sha512.js"></script>

<div class="accounts-update">

    <?= $this->render('_form', [
        'model' => $model,
        'depart' =>$depart,
        'level' => $level,
    ]) ?>

</div>
