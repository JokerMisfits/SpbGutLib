<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AccessLevel;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends AppAdminController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $access = $this->getAccess(Yii::$app->user->identity->access_level);
        if($access == 001){
            return $this->goHome();
        }else{
            return $this->render('index', [
                'access' => $access,
            ]);
        }
    }

    private function getAccess($level){
        $access = AccessLevel::find()
        ->all();
        $count = count($access);
        $newAccess = [];
        for($i = 0;$i < $count;$i++){
            $j =  $access[$i]['access_level'];
            $newAccess[$j] = $access[$i]['access_name'];
        }
        if(isset($newAccess[$level])){
            return $newAccess[$level];
        }
        else{
            return 001;
        }
    }
}
