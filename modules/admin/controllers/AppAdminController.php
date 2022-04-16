<?php


namespace app\modules\admin\controllers;

use yii\base\Model;
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
        Yii::$app->getSession()->setFlash('error', 'Доступ запрещен!');
    }

    public function checkWhiteSpaces(Model $model, $attributes){
        $count = count($attributes);
        $check = true;
        for($i = 0; $i < $count; $i++){
            $attribute = $attributes[$i];
            $value = $model->$attribute;
            if($value[0] == ' '){
                $label = $model->getAttributeLabel($attributes[$i]);
                Yii::$app->getSession()->addFlash('error',"Удалите первый пробел в поле '$label'!");
                $check = false;
            }
        }
        return $check;
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