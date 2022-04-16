<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Accounts;
use app\modules\admin\models\BooksHistory;
use Yii;
use app\modules\admin\models\People;
use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\Department;
use app\modules\admin\models\PeopleSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
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
            $this->AccessDenied();
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
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
        $model = new People();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $findDuplicate = People::find()->where(['pass_number' => $model->pass_number])->one();
            if($findDuplicate != null){
                Yii::$app->getSession()->setFlash('error', 'Данный номер пропуска уже используется!');
                return $this->redirect('create');
            }
            try {
                $model->save();
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect('create');
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'depart' => $this->getDepart(),
            ]);
        }
        return $this->redirect(['view', 'id' => $model->id]);
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
        if (Yii::$app->user->identity->access_level < 100) {
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $oldModel = People::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', 'Измените данные перед отправкой!');
                return $this->render('update', [
                    'model' => $model,
                    'depart' => $this->getDepart(),
                ]);
            }
            if($model->child_id != null){
                $command = Yii::$app->db->createCommand();
                try {
                    $model->save();
                    $this->checkForUpdate($model,$command);
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                }
                catch (\Exception|\Throwable $exception){
                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                    return $this->render('update', [
                        'model' => $model,
                        'depart' => $this->getDepart(),
                    ]);
                }
            }
            else{
                try {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                }
                catch (\Exception|\Throwable $exception){
                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                    return $this->render('update', [
                        'model' => $model,
                        'depart' => $this->getDepart(),
                    ]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
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
            $this->AccessDenied();
            return $this->goHome();
        }
        $model = $this->findModel($id);
        if ($model->access_level >= Yii::$app->user->identity->access_level) {
            $this->AccessDenied();
            return $this->goHome();
        }
        if($model->books == null){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($this->findTasks($model->id) == true){
                    if ($this->findAccounts($model, false) == true) {
                        $model->delete();
                        $transaction->commit();
                    }
                    else{
                        Yii::$app->getSession()->setFlash('error', 'Не удалось удалить Аккаунт!');
                        $transaction->rollBack();
                        return $this->redirect(Url::to(['/admin/people']));
                    }
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                $transaction->rollBack();
                return $this->redirect(Url::to(['/admin/people']));
            }
        }
        else{
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить пользователя, закройте заявки на книги и попробуйте снова!');
            return $this->redirect(Url::to(['/admin/people']));
        }
        Yii::$app->getSession()->setFlash('success', 'Пользователь [' . $model->surname . ' ' . $model->name . ' ' . $model->middle_name . '] успешно удален');
        return $this->redirect(Url::to(['/admin/people']));
    }

    private function getDepart(){
        $department = Department::find()->orderBy(['name' => SORT_ASC])->all();
        $count = count($department);
        $depart = [];
        for($i = 0;$i < $count;$i++){
            $depart[$department[$i]['id']] = $department[$i]['name'];
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
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect(Url::to(['/admin/people']));
            }
        }
        return true;
    }

    private function findTasks($id){
        $model = BooksHistory::find()
            ->where(['user_id' => $id,'active' => 1])
            ->asArray()
            ->one();
        if($model != null){
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить данный аккаунт, закройте заявки на книги у данного пользователя и попробуйте снова!');
            return $this->redirect(Url::to(['/admin/people']));
        }
        $model = BooksHistory::find()
            ->where(['user_id' => $id])
            ->asArray()
            ->all();
        if($model == null){
            return true;
        }
        $count = count($model);
        $db = Yii::$app->db;
        $command = $db->createCommand();
        $transaction = $db->beginTransaction();
        for($i = 0;$i < $count;$i++){
            try {
                $command->delete('books_history',
                    ['user_id' => $id,'active' => 0])
                    ->execute();
            }
            catch (\Exception|\Throwable $exception){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect(Url::to(['/admin/people']));
            }
        }
        try {
            $transaction->commit();
        }
        catch (\Exception|\Throwable $exception){
            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('error', $exception->getMessage());
            return $this->redirect(Url::to(['/admin/people']));
        }
        return true;
    }

    /**
     * Finds the people model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return People the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = People::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
