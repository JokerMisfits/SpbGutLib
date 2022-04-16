<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Accounts;
use Yii;
use app\modules\admin\models\people;
use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\Department;
use app\modules\admin\models\PeopleSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PeopleController implements the CRUD actions for people model.
 */
class PeopleController extends AppAdminController
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
     * Lists all people models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeopleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $access = new AccessLevel();
        $department = new Department();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $access,
            'department' => $department,
        ]);
    }

    /**
     * Displays a single people model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->identity->access_level < 50) {
            return $this->goHome();
        }
        else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new people model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new people();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                $error = $model->errors[array_keys($model->errors)[0]];
                Yii::$app->getSession()->setFlash('error', $error);
                return $this->redirect(['create']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if (Yii::$app->user->identity->access_level < 50) {
            return $this->goHome();
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'depart' => $this->getDepart(),
            ]);
        }
    }

    /**
     * Updates an existing people model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->child_id != null){
                $command = Yii::$app->db->createCommand();
                try {
                    $model->save();
                    $this->checkForUpdate($model,$command);
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                }
                catch (\Exception $exception){
                    Yii::$app->getSession()->setFlash('error', $exception);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
                try {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                }
                catch (\Exception $exception){
                    Yii::$app->getSession()->setFlash('error', $exception);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if (Yii::$app->user->identity->access_level < 50) {
            return $this->goHome();
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'depart' => $this->getDepart(),
            ]);
        }
    }

    /**
     * Deletes an existing people model.
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
            if ($model->access_level >= Yii::$app->user->identity->access_level) {
                return $this->goHome();
            }
            else{
                if ($this->findAccounts($model, false)) {
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

    private function getDepart(){
        $department = Department::find()->all();
        $count = count($department);
        $depart = [];
        for($i = 0;$i < $count;$i++){
            $depart[$i+1] = $department[$i]['name'];
        }
        return $depart;
    }

    private function checkForUpdate(People $model,$command){

        /* @var Accounts $accounts */
        $accounts = (new \yii\db\Query())
            ->from('accounts')
            ->where(['pass_number' => $model->pass_number])
            ->one();
        if ($accounts != null && $accounts->parent_id == null) {
            $command->update('accounts',
                ['parent_id' => $model->id], ['pass_number' => $model->pass_number])
                ->execute();
        }
        if($accounts != null){
            if($accounts->name != $model->name){
                $command->update('accounts',
                    ['name' => $model->name], ['parent_id' => $model->id])
                    ->execute();
            }
            if($accounts->surname != $model->surname){
                $command->update('accounts',
                    ['surname' => $model->surname], ['parent_id' => $model->id])
                    ->execute();
            }
            if($accounts->middle_name != $model->middle_name) {
                $command->update('accounts',
                    ['middle_name' => $model->middle_name], ['parent_id' => $model->id])
                    ->execute();
            }
            if($accounts->pass_number != $model->pass_number){
                $command->update('accounts',
                    ['pass_number' => $model->pass_number], ['parent_id' => $model->id])
                    ->execute();
            }
            if($accounts->department_id != $model->department_id){
                $command->update('accounts',
                    ['department_id' => $model->department_id], ['parent_id' => $model->id])
                    ->execute();
            }
        }

    }

    private function findAccounts(People $child_model,$bool = true){
        /* @var Accounts $model */
        $model = Accounts::find()
            ->where(['pass_number' => $child_model->pass_number])
            ->one();
        if($model != null && $bool == false){
            try{
                $model->delete();
            }
            catch (\Throwable $exception){
                return Yii::$app->getSession()->setFlash('error', $exception);
            }
        }
        return true;
    }

    /**
     * Finds the people model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return people the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = people::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
