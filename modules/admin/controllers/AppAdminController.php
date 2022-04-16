<?php


namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class AppAdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    public static function debug($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

}