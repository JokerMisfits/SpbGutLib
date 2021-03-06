<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\People;
use Yii;
use app\modules\admin\models\Department;
use app\modules\admin\models\DepartmentsSearch;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * DepartmentsController implements the CRUD actions for Department model.
 */
class DepartmentsController extends AppAdminController
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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        $searchModel = new DepartmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Department model.
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

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 100){
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = new Department();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['name'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('create', ['model' => $model]);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', '?????????????? ?????????????? ??????????????????.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/departments');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 100){
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['name'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('update', ['model' => $model]);
            }
            $oldModel = Department::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', '???????????????? ???????????? ?????????? ??????????????????!');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', '?????????????????? ?????????????? ??????????????????.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/departments');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Department model.
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

        $people = People::find()->where(['department_id' => $id])->one();
        if($people == null){
            $model = $this->findModel($id);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->delete()){
                    Yii::$app->getSession()->setFlash('success', '?????????????? [' . $model->name . '] ?????????????? ??????????????.' );
                    $transaction->commit();
                    return $this->redirect('/admin/departments');
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/departments');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect('/admin/departments');
            }
        }
        else{
            Yii::$app->getSession()->setFlash('error', '???????????? ?????????????? ?????? ????????????????????????! '. Html::a(Html::encode('?????????????? ?? ???????????? ??????????????????????????'), Url::to(['people/', 'PeopleSearch[department_id]' => $id])));
            return $this->redirect('/admin/departments');
        }
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????????? ???????????????? ???? ??????????????.');
    }
}
