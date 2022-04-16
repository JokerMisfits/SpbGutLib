<?php


namespace app\controllers;

use Yii;
use yii\web\Controller;

class AppController extends Controller
{
    public static function debug($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
    public static function AccessDenied(){
        return Yii::$app->getSession()->setFlash('error', 'Доступ запрещен');
    }
}