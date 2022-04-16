<?php


namespace app\controllers;


use yii\web\Controller;

class AppController extends Controller
{
    public static function debug($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}