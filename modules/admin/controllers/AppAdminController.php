<?php


namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

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

    public static function AccessDenied(){
        return Yii::$app->getSession()->setFlash('error', 'Доступ запрещен');
    }
    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest == false){
            $id = Yii::$app->user->identity->id;
            Yii::$app->db->createCommand()
                ->update('accounts', ['last_activity_timestamp' => time()], "id = $id")
                ->execute();
        }
        return true;
    }

}