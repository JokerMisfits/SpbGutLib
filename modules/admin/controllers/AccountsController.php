<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\Department;
use app\modules\admin\models\People;
use Yii;
use app\modules\admin\models\Accounts;
use app\modules\admin\models\AccountsSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountsController implements the CRUD actions for Accounts model.
 */
class AccountsController extends AppAdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
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

    /**
     * Lists all Accounts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $access = new AccessLevel();
        $department= new Department();
        if (Yii::$app->user->identity->access_level < 100) {
            return $this->goHome();
        }
        else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'access' => $access,
                'department' => $department,
            ]);
        }
    }

    /**
     * Displays a single Accounts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->identity->access_level < 100) {
            return $this->goHome();
        }
        else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Accounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->access_level < 100) {
            return $this->goHome();
        }
        else{
            $model = new Accounts();
            if ($model->load(Yii::$app->request->post())) {
                $id = (new \yii\db\Query())
                    ->select('id')
                    ->from('accounts')
                    ->addOrderBy('id DESC')
                    ->one();
                $model->id = (integer)$id['id'] + 1;
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->parent_id = $this->findPeople($model);
                if($model->parent_id == null){
                    $command = Yii::$app->db->createCommand();
                    $command->insert('people', array(
                        'name'=> $model->name,
                        'surname'=> $model->surname,
                        'middle_name'=> $model->middle_name,
                        'access_level'=> $model->access_level,
                        'child_id'=> $model->id,
                        'pass_number'=> $model->pass_number,
                        'department_id' => $model->department_id,
                    ))->execute();
                    $parent = (new \yii\db\Query())
                        ->select('id')
                        ->from('people')
                        ->where(['child_id' => $model->id])
                        ->one();
                    $model->parent_id = $parent['id'];
                }
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    $error = $model->errors[array_keys($model->errors)[0]];
                    Yii::$app->getSession()->setFlash('error', $error);
                    return $this->redirect(['create']);
                }

            }
            return $this->render('create',[
                'model' => $model,
                'depart' => $this->getDepart(),
                'level' => $this->getAccess(),
            ]);
        }
    }

    /**
     * Updates an existing Accounts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $command = Yii::$app->db->createCommand();
            if($model->parent_id == null){
                if($model->pass_number == null){
                    $command->insert('people', array(
                        'name'=> $model->name,
                        'surname'=> $model->surname,
                        'middle_name'=> $model->middle_name,
                        'access_level'=> $model->access_level,
                        'child_id'=> $model->id,
                    ))->execute();
                    $parent = (new \yii\db\Query())
                        ->select('id')
                        ->from('people')
                        ->where(['child_id' => $model->id])
                        ->one();
                    $model->parent_id = $parent['id'];
                }
                else{
                    $pass = (new \yii\db\Query())
                        ->select('id')
                        ->from('people')
                        ->where(['pass_number' => $model->pass_number])
                        ->one();
                    if($pass['id'] != null){
                        $model->parent_id = $pass['id'];
                        $command->update('people',
                            ['child_id' => $model->id], ['id' => $model->parent_id])
                            ->execute();
                    }
                    else{
                        $command->insert('people', array(
                            'name'=> $model->name,
                            'surname'=> $model->surname,
                            'middle_name'=> $model->middle_name,
                            'access_level'=> $model->access_level,
                            'child_id'=> $model->id,
                            'pass_number'=> $model->pass_number,
                        ))->execute();
                        $parent = (new \yii\db\Query())
                            ->select('id')
                            ->from('people')
                            ->where(['child_id' => $model->id])
                            ->one();
                        $model->parent_id = $parent['id'];
                    }

                }
            }
            try {
                $model->save();
                $this->checkForUpdate($model,$command);
                Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            catch (\Exception $exception){
                Yii::$app->getSession()->setFlash('error', $exception);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        if (Yii::$app->user->identity->access_level < 100) {
            return $this->goHome();
        }
        else{
            return $this->render('update', [
                'model' => $model,
                'depart' => $this->getDepart(),
                'level' => $this->getAccess(),
            ]);
        }

    }


    private function checkForUpdate(Accounts $model,$command,$find = true){
        /* @var People $people */
        if($find == true){
            $people = (new \yii\db\Query())
                ->from('people')
                ->where(['child_id' => $model->id])
                ->one();
        }
        if($people == null){
            $people = (new \yii\db\Query())
                ->from('people')
                ->where(['pass_number' => $model->pass_number])
                ->one();
            if ($people != null) {
                $command->update('people',
                    ['child_id' => $model->id], ['pass_number' => $model->pass_number])
                    ->execute();
            }
        }
        if($people != null){
            if($people->name != $model->name){
                $command->update('people',
                    ['name' => $model->name], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->surname != $model->surname){
                $command->update('people',
                    ['surname' => $model->surname], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->middle_name != $model->middle_name){
                $command->update('people',
                    ['middle_name' => $model->middle_name], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->access_level != $model->access_level){
                $command->update('people',
                    ['access_level' => $model->access_level], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->pass_number != $model->pass_number){
                $command->update('people',
                    ['pass_number' => $model->pass_number], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->department_id != $model->department_id){
                $command->update('people',
                    ['department_id' => $model->department_id], ['child_id' => $model->id])
                    ->execute();
            }
            if($people->child_id != $model->id){
                $command->update('people',
                    ['child_id' => $model->id], ['pass_number' => $model->pass_number])
                    ->execute();
            }
        }

    }

    private function getDepart(){
        $department = Department::find()->all();
        $count = count($department);
        $depart = [];
        for($i = 0;$i < $count;$i++){
            $depart[$i+1] = $department[$i]['name'];
        }
        return $depart;
    }

    private function getAccess(){
        $access = AccessLevel::find()->all();
        $count = count($access);
        $level = [];
        for($i = 0;$i < $count;$i++){
            $level[$access[$i]['access_level']] = $access[$i]['access_name'];
        }
        return $level;
    }

    private function findPeople(Accounts $parent_model,$bool = true){
        /* @var People $model */
        $model = People::find()
            ->where(['pass_number' => $parent_model->pass_number])
            ->one();
        if($model != null && $bool == false){
            try{
                $model->delete();
            }
            catch (\Throwable $exception){
                return Yii::$app->getSession()->setFlash('error', $exception);
            }
            return true;
        }
        if($model != null){
            $parent_model->parent_id = $model['id'];
            $command = Yii::$app->db->createCommand();
            $this->checkForUpdate($parent_model,$command,false);
        }
        return $parent_model->parent_id;
    }

    /**
     * Deletes an existing Accounts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->access_level < 100) {
            return $this->goHome();
        }
        else{
            $model = $this->findModel($id);
            if($model->access_level >= Yii::$app->user->identity->access_level){
                return $this->goHome();
            }
            else{
                if($this->findPeople($model,false)){
                    Yii::$app->getSession()->setFlash('success', 'Пользователь из таблицы accounts и people [' . $model->surname . ' ' . $model->name . ' ' . $model->middle_name . '] успешно удален');
                    try{
                        $model->delete();
                    }
                    catch (\Throwable $exception){
                        return Yii::$app->getSession()->setFlash('error', $exception);
                    }
                }
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Accounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accounts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
