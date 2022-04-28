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
        Yii::$app->getSession()->setFlash('error', 'Доступ запрещен!');
    }

    public function beforeAction($action) : bool{
        if(!Yii::$app->user->isGuest){
            $id = Yii::$app->user->identity->id;
            Yii::$app->db->createCommand()
                ->update('accounts', ['last_activity_timestamp' => time()], "id = $id")
                ->execute();
        }
        return true;
    }

}