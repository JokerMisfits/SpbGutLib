<?php

/* @var $this yii\web\View */

$this->title = 'LitDB';
use yii\helpers\Html;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p class="lead">Это web-сервис для учета и поиска литературы кафедры ИиРВ.</p>
        <hr class="my-4">
        <?php
        if(Yii::$app->user->isGuest){
            echo '<p class="text-warning">Для продолжения работы, пожалуйста '. Html::a('авторизуйтесь', ['login']) . '!</p>';
        }
        elseif(Yii::$app->user->identity->access_level >= 50){
            echo '<p class="text-warning">Рекомендуется ознакомиться с ' . Html::a('инструкциями', ['about']) . ' по работе с данным сервисом!</p>';
        }
        else{
            echo '<p class="text-warning">Начать работу с данным  '. Html::a('сервисом', ['/admin/']) . '!</p>';
        }
        ?>

    </div>
</div>
