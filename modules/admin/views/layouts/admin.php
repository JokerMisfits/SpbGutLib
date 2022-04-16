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
        'brandUrl' => '/admin',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => Url::to('/')],

                Yii::$app->user->identity->access_level < 50 ? ('') : (
                [
                    'label' => 'Accounts',
                    'items' => [
                        ['label' => 'Create', 'url' => Url::to('/admin/accounts/create/')],
                        ['label' => 'Read', 'url' => Url::to('/admin/accounts/index')],
                    ],
                ]),

                Yii::$app->user->identity->access_level < 50 ? ('') : (
                [
                    'label' => 'Books',
                    'items' => [
                        ['label' => 'Books', 'url' => Url::to('/admin/books')],
                        ['label' => 'Categories', 'url' => Url::to('/admin/books-categories')],
                        ['label' => 'Subjects', 'url' => Url::to('/admin/books-subjects')],
                        ['label' => 'Tasks', 'url' => Url::to('/admin/books-history')],
                    ],
                ]),

                Yii::$app->user->identity->access_level < 50 ? (
                ['label' => 'Books', 'url' => Url::to('/admin/books')]) : (''),

                Yii::$app->user->identity->access_level < 100 ? ('') : (
                [
                    'label' => 'Departments',
                    'items' => [
                        ['label' => 'Create', 'url' => Url::to('/admin/departments/create')],
                        ['label' => 'Read', 'url' => Url::to('/admin/departments')],
                    ],
                ]),

                Yii::$app->user->identity->access_level < 50 ? ('') : (
                [
                    'label' => 'Users',
                    'items' => [
                        ['label' => 'Create', 'url' => Url::to('/admin/people/create')],
                        ['label' => 'Read', 'url' => Url::to('/admin/people')],
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
    }
    catch (Exception $exception){
        return Yii::$app->getSession()->setFlash('error', $exception);
    }
    ?>

    <div class="admin-layout container col-xs-12 col-lg-12">
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
