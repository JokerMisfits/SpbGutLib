<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\Books;
use app\modules\admin\models\BooksHistory;
use app\modules\admin\models\People;
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
        return $this->render('index', [
            'access' => $this->getAccess(Yii::$app->user->identity->access_level),
            'task' => $this->getTask(Yii::$app->user->identity->parent_id),
            'books' => $this->getBooks(),
            'people' => $this->getPeople(),
            'tasks' => $this->getTasks(),
        ]);
    }

    private function getAccess($level){
        $access = AccessLevel::find()
        ->where(['access_level' => $level])
        ->one();
        return $access['access_name'];
    }
    private function getTask($id){
        $tasks = BooksHistory::find()
            ->where(['user_id' => $id,'active' => 1])
            ->count();
        return $tasks;
    }
    private function getBooks(){
       return Books::find()->count();
    }
    private function getPeople(){
        return People::find()->count();
    }
    private function getTasks(){
        return BooksHistory::find()->count();
    }
}
