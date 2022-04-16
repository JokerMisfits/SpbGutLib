<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\Accounts;
use app\modules\admin\models\Books;
use app\modules\admin\models\BooksCategories;
use app\modules\admin\models\BooksHistory;
use app\modules\admin\models\BooksSubjects;
use app\modules\admin\models\Department;
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

        if(Yii::$app->user->isGuest == true){
            $this->AccessDenied();
            return $this->goHome();
        }

        return $this->render('index', [
            'access' => $this->getAccess(Yii::$app->user->identity->access_level),
            'task' => $this->getTask(Yii::$app->user->identity->parent_id),
            'books' => $this->getBooksCount(),
            'people' => $this->getPeopleCount(),
            'tasks' => $this->getTasksCount(),
            'depart' => $this->getDepart(Yii::$app->user->identity->department_id),
            'email' => Yii::$app->user->identity->email,
            'pass' => Yii::$app->user->identity->pass_number,
            'username' => Yii::$app->user->identity->username,
            'comment' => $this->getComment(Yii::$app->user->identity->parent_id),
            'categories' => $this->getCategoriesCount(),
            'subjects' => $this->getSubjectsCount(),
            'registration' => Yii::$app->user->identity->registration_timestamp,
            'status' => $this->getStatus(Yii::$app->user->identity->id),
            'online' => $this->getOnline(),
        ]);
    }


    private function getOnline(){
        $timestamp = time();
        $timestamp = $timestamp - 900;
        $status = Accounts::find()
            ->andFilterCompare('last_activity_timestamp', ">$timestamp")
            ->count();
        return $status;
    }
    private function getStatus($id){
        if($id == Yii::$app->user->identity->id){
            return '<span class="text-success">Online</span>';
        }
        else{
            $status = Accounts::find()
                ->where(['id' => $id])
                ->one();
            $status = $status['last_activity_timestamp'];
            if($status == null){
                return '<b class="text-danger">Offline</b>';
            }
            $timestamp = time();
            $difference = $timestamp - $status;
            if($difference <= 900){
                return '<b class="text-success">Online</b>';
            }
            else{
                return '<b class="text-danger">' . $status . '</b>';
            }
        }
    }
    private function getComment($id){
        $comment = People::find()
            ->where(['id' => $id])
            ->one();
        return $comment['comment'];
    }
    private function getDepart($id){
        $depart = Department::find()
        ->where(['id' => $id])
        ->one();
        return $depart['name'];
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
    private function getBooksCount(){
       return Books::find()->count();
    }
    private function getCategoriesCount(){
        return BooksCategories::find()->count();
    }
    private function getSubjectsCount(){
        return BooksSubjects::find()->count();
    }
    private function getPeopleCount(){
        return People::find()->count();
    }
    private function getTasksCount(){
        return BooksHistory::find()->count();
    }
}
