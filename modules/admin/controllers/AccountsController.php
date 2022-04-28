<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AccessLevel;
use app\modules\admin\models\BooksHistory;
use app\modules\admin\models\Department;
use app\modules\admin\models\People;
use Yii;
use app\modules\admin\models\Accounts;
use app\modules\admin\models\AccountsSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AccountsController implements the CRUD actions for Accounts model.
 */
class AccountsController extends AppAdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() : array{
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

        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        $searchModel = new AccountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $access = new AccessLevel();
        $department= new Department();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $access,
            'department' => $department,
        ]);
    }

    /**
     * Displays a single Accounts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
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
     * Creates a new Accounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 100){
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = new Accounts();
        $model->scenario = Accounts::SCENARIO_FORM;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->password[0] == ' '){
                $model->password = null;
            }
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['surname', 'name', 'middle_name'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                $model->password = null;
                $model->password_confirm = null;
                return $this->render('create', ['model' => $model, 'depart' => $this->getDepart(), 'level' => $this->getAccess()]);
            }
            if(strlen($model->password) < 128 || strlen($model->password) > 128 || strlen($model->password_confirm) < 128 || strlen($model->password_confirm) > 128){
                Yii::$app->getSession()->setFlash('error', 'Разрешите использование JavaScript на данной странице!');
                return $this->redirect('/admin/accounts/create');
            }
            if(strlen($model->pass_number) < 4 || strlen($model->pass_number) > 25){
                Yii::$app->getSession()->setFlash('error', 'Номер пропуска не должен быть меньше 4 символов и не должен привышать 25 символов!');
                return $this->redirect('/admin/accounts/create');
            }
            $findDuplicate = Accounts::find()->where(['pass_number' => $model->pass_number])->one();
            if($findDuplicate != null){
                Yii::$app->getSession()->setFlash('error', 'Данный номер пропуска уже используется!');
                return $this->redirect('/admin/accounts/create');
            }
            $model->scenario = Accounts::SCENARIO_SAVE;
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $model->parent_id = $this->findPeople($model);
            $model->registration_timestamp = (string)time();
            $model->last_activity_timestamp = null;
            $model->surname = ucfirst($model->surname);
            $model->name = ucfirst($model->name);
            $model->middle_name = ucfirst($model->middle_name);
            $db = Yii::$app->db;
                if($model->parent_id == null) {
                    $transaction = $db->beginTransaction();
                    try {
                        $db->createCommand()->insert('people', array(
                            'name'=> $model->name,
                            'surname'=> $model->surname,
                            'middle_name'=> $model->middle_name,
                            'access_level'=> $model->access_level,
                            'pass_number'=> $model->pass_number,
                            'department_id' => $model->department_id,
                        ))->execute();
                        $parent = (new \yii\db\Query())
                            ->select('id')
                            ->from('people')
                            ->where(['pass_number' => $model->pass_number])
                            ->one();
                        $model->parent_id = $parent['id'];
                        if($model->save()){
                            $db->createCommand()->update('people',
                                ['child_id' => $model->id], ['pass_number' => $model->pass_number])->execute();
                            $db->transaction->commit();
                        }
                        else{
                            Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                            $transaction->rollBack();
                            return $this->redirect('/admin/accounts/create');
                        }
                    }
                    catch (\Exception|\Throwable $exception) {
                        Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                        $transaction->rollBack();
                        return $this->redirect('/admin/accounts/create');
                    }
                }
                else{
                    $transaction = $db->beginTransaction();
                    /* @var People $child_model */
                    $child_model = People::find()
                        ->where(['pass_number' => $model->pass_number])
                        ->one();
                    $command = Yii::$app->db->createCommand();
                    try {
                        if($model->save()){
                            $this->checkForUpdate($model,$command,$child_model);
                            $transaction->commit();
                        }
                        else{
                            Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                            $transaction->rollBack();
                            return $this->redirect('/admin/accounts/create');
                        }

                    }
                    catch (\Exception|\Throwable $exception){
                        Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                        $transaction->rollBack();
                        return $this->redirect('/admin/accounts/create');
                    }
                }
                return $this->redirect(['/admin/accounts/view', 'id' => $model->id]);
            }
        return $this->render('create',[
            'model' => $model,
            'depart' => $this->getDepart(),
            'level' => $this->getAccess(),
        ]);
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
        /* @var People $child_model */
        $model = $this->findModel($id);

        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        if(Yii::$app->user->identity->access_level == 50){
            if(Yii::$app->user->identity->access_level == $model->access_level && Yii::$app->user->identity->id != $model->id){
                Yii::$app->getSession()->setFlash('error', 'Запрещено редактировать профили других модераторов!');
                return $this->redirect('/admin/accounts');
            }
            elseif(Yii::$app->user->identity->access_level < $model->access_level){
                Yii::$app->getSession()->setFlash('error', 'Запрещено редактировать профили администраторов!');
                return $this->redirect('/admin/accounts');
            }
        }

        if(Yii::$app->user->identity->access_level == 100){
            if(Yii::$app->user->identity->access_level == $model->access_level && Yii::$app->user->identity->id != $model->id){
                Yii::$app->getSession()->setFlash('error', 'Запрещено редактировать профили других администраторов!');
                return $this->redirect('/admin/accounts');
            }
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post())) {
            $attributes = ['surname', 'name', 'middle_name'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('update', ['model' => $model, 'depart' => $this->getDepart(), 'level' => $this->getAccess()]);
            }
            $model->surname = ucfirst($model->surname);
            $model->name = ucfirst($model->name);
            $model->middle_name = ucfirst($model->middle_name);
            $db = Yii::$app->db;
            $oldModel = Accounts::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', 'Измените данные перед отправкой!');
                return $this->render('update', [
                    'model' => $model,
                    'depart' => $this->getDepart(),
                    'level' => $this->getAccess(),
                ]);
            }
            $model->scenario = Accounts::SCENARIO_SAVE;
            $transaction = $db->beginTransaction();
            try {
                if($model->save()){
                    $child_model = People::find()
                        ->where(['pass_number' => $model->pass_number])
                        ->one();
                    if($child_model != null){
                        $this->checkForUpdate($model,$db->createCommand(),$child_model);
                    }
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены.');
                    $transaction->commit();
                    return $this->redirect(['/admin/accounts/view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/accounts');
                }
            }
            catch (\Exception|\Throwable $exception){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect(['/admin/accounts/view', 'id' => $model->id]);
            }
        }

        else{
            return $this->render('update', [
                'model' => $model,
                'depart' => $this->getDepart(),
                'level' => $this->getAccess(),
            ]);
        }

    }

    private function checkForUpdate(Accounts $model,$command,People $child_model){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($child_model->child_id != $model->id){
                $command->update('people',
                    ['child_id' => $model->id], ['pass_number' => $model->pass_number])
                    ->execute();
            }
            if($child_model->name != $model->name){
                $command->update('people',
                    ['name' => $model->name], ['child_id' => $model->id])
                    ->execute();
            }
            if($child_model->surname != $model->surname){
                $command->update('people',
                    ['surname' => $model->surname], ['child_id' => $model->id])
                    ->execute();
            }
            if($child_model->middle_name != $model->middle_name){
                $command->update('people',
                    ['middle_name' => $model->middle_name], ['child_id' => $model->id])
                    ->execute();
            }
            if($child_model->access_level != $model->access_level){
                $command->update('people',
                    ['access_level' => $model->access_level], ['child_id' => $model->id])
                    ->execute();
            }
            if($child_model->department_id != $model->department_id){
                $command->update('people',
                    ['department_id' => $model->department_id], ['child_id' => $model->id])
                    ->execute();
            }
            $transaction->commit();
        }
        catch (\Exception|\Throwable $exception){
            $transaction->rollBack();
            return new \Exception('Произошла ошибка при обновлении таблицы People');
        }
        return true;

    }

    private function getDepart() : array{
        $department = Department::find()->orderBy(['name' => SORT_ASC])->all();
        $count = count($department);
        $depart = [];
        for($i = 0;$i < $count;$i++){
            $depart[$department[$i]['id']] = $department[$i]['name'];
        }
        return $depart;
    }

    private function getAccess() : array{
        $access = AccessLevel::find()->all();
        $count = count($access);
        $level = [];
        for($i = 0;$i < $count;$i++){
            $level[$access[$i]['access_level']] = $access[$i]['access_name'];
        }
        return $level;
    }

    private function findPeople(Accounts $parent_model,$bool = true){
        /* @var People $child_model */
        $child_model = People::find()
            ->where(['pass_number' => $parent_model->pass_number])
            ->one();
        if($child_model != null && $bool == false){
            if($child_model->books == null){
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    $child_model->delete();
                    $transaction->commit();
                }
                catch (\Exception|\Throwable $exception){
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                    return $this->redirect('/admin/accounts');
                }
            }
            else{
                return false;
            }
            return true;
        }
        elseif($child_model != null && $bool = true){
            return $child_model['id'];
        }
        return null;
    }

    private function findTasks($id){
        $model = BooksHistory::find()
            ->where(['user_id' => $id,'active' => 1])
            ->asArray()
            ->one();
        if($model != null){
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить данный аккаунт, закройте заявки на книги у данного пользователя и попробуйте снова!');
            return false;
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
                return false;
            }
        }
        try {
            $transaction->commit();
        }
        catch (\Exception|\Throwable $exception){
            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('error', $exception->getMessage());
            return false;
        }
        return true;
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
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 100){
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if($model->id == Yii::$app->user->identity->id){
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить свой аккаунт!');
            return $this->redirect('/admin/accounts');
        }
        elseif(Yii::$app->user->identity->access_level > $model->access_level){
            if($this->findTasks($model->parent_id) == true){
                if($this->findPeople($model,false) == false){
                    Yii::$app->getSession()->setFlash('error', 'Невозможно удалить данный аккаунт, закройте заявки на книги у данного пользователя и попробуйте снова!');
                    return $this->redirect('/admin/accounts');
                }
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    if($model->delete()){
                        $transaction->commit();
                        Yii::$app->getSession()->setFlash('success', 'Аккаунт и пользователь [' . $model->surname . ' ' . $model->name . ' ' . $model->middle_name . '] успешно удален.');
                        return $this->redirect('/admin/accounts');
                    }
                    else{
                        Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                        $transaction->rollBack();
                        return $this->redirect('/admin/accounts');
                    }
                }
                catch (\Exception|\Throwable $exception){
                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                    return $this->redirect('/admin/accounts');
                }
            }
            else{
                return $this->redirect('/admin/accounts');
            }
        }
        else{
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить данный аккаунт, ваш уровень доступа должен быть выше чем у аккаунта, который вы пытаетесь удалить, дальнейшие попытки приведут к блокировке!');
            return $this->redirect('/admin/accounts');
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

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
