<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
date_default_timezone_set('Europe/Moscow');
$config = [
    'id' => 'basic',
    'name' => 'LitDB',
    'version' => 'Alpha 0.03',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-Ru',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'admin',
        ],
    ],
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xWo2yez7zOuMIvX8wM3NjG-np3wJW0xy',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '',
            'rules' => [
                '<action:(about|contact|login|update)>' => 'site/<action>',
                '<action:(create|read|update|delete)>' => 'admin/<action>',
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
//            'nodes' => [
//                ['http_address' => '127.0.0.1:9200'],
                //настройте несколько хостов, если у вас есть кластер
//            ],
            // установите autodetectCluster = false, чтобы не определять адреса узлов в кластере автоматически
            // 'autodetectCluster' => false,
            'dslVersion' => 7, // по умолчанию - 5
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['*'],
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //'allowedIPs' => ['*'],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
