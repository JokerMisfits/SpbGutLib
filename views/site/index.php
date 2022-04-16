<?php

/* @var $this yii\web\View */

$this->title = 'LitDB';
use yii\helpers\Html;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p class="lead">Это web-сервис для учета и поиска летературы кафедры ИиРВ.</p>
        <hr class="my-4">
        <p class="text-warning">Для продолжения работы, пожалуйста <?= Html::a('авторизуйтесь', ['login']) ?>!</p>
    </div>
</div>
