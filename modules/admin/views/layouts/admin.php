<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
$this->registerCssFile("@web/css/admin.css");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Yii::$app->name ?></title>
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
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'AdminPanel',
        'brandUrl' => '/admin',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/']],


            Yii::$app->user->identity->access_level < 100 ? (
            [
                    'label' => 'Books',
                    'items' => [
                        ['label' => 'Read', 'url' => '/admin/books/'],
                    ],
            ]
            ) : (
            [
                'label' => 'Users',
                'items' => [
                    ['label' => 'Create', 'url' => '/admin/people/create'],
                    ['label' => 'Read', 'url' => '/admin/people/'],
                ],
            ]),

            Yii::$app->user->identity->access_level < 100 ? ('') : (
            [
                    'label' => 'Accounts',
                    'items' => [
                        ['label' => 'Create', 'url' => '/admin/accounts/create'],
                        ['label' => 'Read', 'url' => '/admin/accounts'],
                    ],
            ]),

            Yii::$app->user->identity->access_level < 100 ? ('') : (
            [
                'label' => 'Books',
                'items' => [
                    ['label' => 'Create', 'url' => '/admin/books/create'],
                    ['label' => 'Read', 'url' => '/admin/books/'],
                ],
            ]),

            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);

    NavBar::end();
    ?>

    <div class="admin-layout container col-xs-12 col-lg-12">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer col-xs-12">
    <div class="container">
            <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= Yii::$app->getVersion() ?> <?= date('Y-m-d H:i:s') ?></p>

            <p class="pull-right"><?= 'Powered by SpbGut'; ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
