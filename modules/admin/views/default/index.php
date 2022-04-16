<?php
/* @var $access */
?>
<div class="admin-default-index col-xs-12" >
    <div class="admin-default-index-profile col-xs-12 col-lg-4 text-center" >
        <p><?= 'Здравствуйте, ' . Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->surname ?></p>
        <p><?= 'Уровень доступа:  ' . $access ?>

        </p>
    </div>
    <div class="admin-default-index-stats col-xs-12 col-lg-8 text-center">
        <p>Этот сайт сделан для демонстрации функционала, весь дизайн может быть изменен</p>
        <p>Здесь можеть быть ваша реклама )))</p>
    </div>
</div>
