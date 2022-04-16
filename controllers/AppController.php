<?php


namespace app\controllers;

use app\modules\admin\models\Accounts;
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