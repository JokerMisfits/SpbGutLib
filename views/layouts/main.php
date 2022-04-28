<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

    AppAsset::register($this);

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
    <meta name="mailru-domain" content="l5o9r7pCPWrLwtJC" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="background-color: #eee">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $name = '';
    if(Yii::$app->user->isGuest){
        $bool = true;
    }
    else{
        $bool = false;
        $name = Yii::$app->user->identity->name;
    }
    $access = true;
    if(isset(Yii::$app->user->identity->access_level) && Yii::$app->user->identity->access_level >= 50){
        $access = false;
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/']],
            $bool ? (
            ''
            ) : (
            ['label' => 'Обновления', 'url' => ['/update']]
            ),
            $access ? (
            ''
            ) : (
            ['label' => 'Инструкции', 'url' => ['/about']]
            ),
            $bool ? (
                ''
            ) : (
              ['label' => 'Профиль', 'url' => ['/admin']]
            ),
            ['label' => 'Обратная связь', 'url' => ['/contact']],
            $bool ? (
                ['label' => 'Войти', 'url' => ['/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . $name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
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
