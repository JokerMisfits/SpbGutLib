<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Books;
use Yii;
use app\modules\admin\models\BooksSubjects;
use app\modules\admin\models\BooksSubjectsSearch;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BooksSubjectsController implements the CRUD actions for BooksSubjects model.
 */
class BooksSubjectsController extends AppAdminController
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
     * Lists all BooksSubjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
        $searchModel = new BooksSubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BooksSubjects model.
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BooksSubjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
        $model = new BooksSubjects();
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
                    Yii::$app->getSession()->setFlash('success', 'Тематика успешно сохранена.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-subjects');
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
     * Updates an existing BooksSubjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->access_level < 50) {
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
            $oldModel = BooksSubjects::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', 'Измените данные перед отправкой!');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-subjects');
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
     * Deletes an existing BooksSubjects model.
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
        $books = Books::find()->where(['subject_id' => $id])->one();
        if($books == null){
            $model = $this->findModel($id);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->delete()){
                    Yii::$app->getSession()->setFlash('success', 'Тематика [' . $model->name . '] успешно удалена.' );
                    $transaction->commit();
                    return $this->redirect('/admin/books-subjects');
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-subjects');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect('/admin/books-subjects');
            }
        }
        else{
            Yii::$app->getSession()->setFlash('error', 'Данная тематика еще используется! '. Html::a(Html::encode('Перейти к данным книгам'), Url::to(['books/', 'BooksSearch[subject_id]' => $id])));
            return $this->redirect('/admin/books-subjects');
        }
    }

    /**
     * Finds the BooksSubjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BooksSubjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BooksSubjects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
