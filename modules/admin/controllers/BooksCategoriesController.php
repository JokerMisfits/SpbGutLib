<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\BooksCategories;
use app\modules\admin\models\BooksCategoriesSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\Books;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BooksCategoriesController implements the CRUD actions for BooksCategories model.
 */
class BooksCategoriesController extends AppAdminController
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
     * Lists all BooksCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
        $searchModel = new BooksCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BooksCategories model.
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
     * Creates a new BooksCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BooksCategories();
        if (Yii::$app->user->identity->access_level < 50) {
            $this->AccessDenied();
            return $this->goHome();
        }
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
                    Yii::$app->getSession()->setFlash('success', 'Категория успешно сохранена.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-categories');
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
     * Updates an existing BooksCategories model.
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
            $oldModel = BooksCategories::find()->where(['id' => $model->id])->one();
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
                    return $this->redirect('/admin/books-categories');
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
     * Deletes an existing BooksCategories model.
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
        $books = Books::find()->where(['category_id' => $id])->one();
        if($books == null){
            $model = $this->findModel($id);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->delete()){
                    Yii::$app->getSession()->setFlash('success', 'Категория [' . $model->name . '] успешно удалена.' );
                    $transaction->commit();
                    return $this->redirect('/admin/books-categories');
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-categories');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect('/admin/books-categories');
            }
        }
        else{
            Yii::$app->getSession()->setFlash('error', 'Данная категория еще используется! '. Html::a(Html::encode('Перейти к данным книгам'), Url::to(['books/', 'BooksSearch[category_id]' => $id])));
            return $this->redirect('/admin/books-categories');
        }
    }

    /**
     * Finds the BooksCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BooksCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BooksCategories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
