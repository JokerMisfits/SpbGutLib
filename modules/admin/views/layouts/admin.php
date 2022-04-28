<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\helpers\Url;

    AppAsset::register($this);
    $this->registerCssFile("@web/css/admin.css");
    $this->title = 'Профиль';

    $access = 0;
    if(isset(Yii::$app->user->identity->access_level)){
        $access = Yii::$app->user->identity->access_level;
    }

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->registerLinkTag([
        'rel' => 'shortcut icon',
        'type' => 'image/x-icon',
        'href' => '../../web/favicon.ico',
    ]);?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style>
        form div.required label.control-label:after {
            content:" *";
            color:red;
        }
        th{
            text-align: center!important;
        }
        .summary{
            text-align: left!important;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => '/',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Профиль', 'url' => Url::to('/admin')],

                $access < 50 ? ('') : (
                [
                    'label' => 'Аккаунты',
                    'items' => [
                        $access == 100 ? (
                        ['label' => 'Создать', 'url' => Url::to('/admin/accounts/create')]
                        )
                        :
                        (
                        ['label' => 'Просмотр', 'url' => Url::to('/admin/accounts')]
                        ),
                        $access == 100 ? (
                        ['label' => 'Просмотр', 'url' => Url::to('/admin/accounts')]
                        ):(''),
                    ],
                ]),

                $access < 50 ? ('') : (
                [
                    'label' => 'Книги',
                    'items' => [
                        ['label' => 'Книги', 'url' => Url::to('/admin/books')],
                        ['label' => 'Категории', 'url' => Url::to('/admin/books-categories')],
                        ['label' => 'Тематики', 'url' => Url::to('/admin/books-subjects')],
                        ['label' => 'Заявки', 'url' => Url::to('/admin/books-history')],
                    ],
                ]),

                $access < 50 ? (
                ['label' => 'Книги', 'url' => Url::to('/admin/books')]) : (''),

                $access < 100 ? ('') : (
                [
                    'label' => 'Кафедры',
                    'items' => [
                        ['label' => 'Создать', 'url' => Url::to('/admin/departments/create')],
                        ['label' => 'Просмотр', 'url' => Url::to('/admin/departments')],
                    ],
                ]),

                $access < 50 ? ('') : (
                [
                    'label' => 'Пользователи',
                    'items' => [
                        ['label' => 'Создать', 'url' => Url::to('/admin/people/create')],
                        ['label' => 'Просмотр', 'url' => Url::to('/admin/people')],
                    ],
                ]),

                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->name . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
        NavBar::end();
    }
    catch (Exception $exception){
        return Yii::$app->getSession()->setFlash('error', $exception);
    }
    ?>

    <div class="admin-layout container-fluid">
        <?php try{
            echo Alert::widget();
        }
        catch (Exception $exception){
            return Yii::$app->getSession()->setFlash('error', $exception);
        }
         ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="container">
            <b>
                <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= Yii::$app->getVersion() ?></p>

                <p class="pull-right"><?= 'Powered by SpbGut'; ?></p>
            </b>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
