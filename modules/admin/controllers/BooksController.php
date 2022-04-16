<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\BooksCategories;
use app\modules\admin\models\BooksSubjects;
use Yii;
use app\modules\admin\models\Books;
use app\modules\admin\models\BooksSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends AppAdminController
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
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $category = new BooksCategories();
        $subject = new BooksSubjects();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'subject' => $subject,

        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->access_level < 50) {
            return $this->goHome();
        }
        else{
            $model = new Books();

            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    $error = $model->errors[array_keys($model->errors)[0]];
                    Yii::$app->getSession()->setFlash('error', $error);
                    return $this->redirect(['create']);
                }

            }

            return $this->render('create', [
                'model' => $model,
                'category' => $this->getCategory(),
                'subject' => $this->getSubject(),
            ]);
        }
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->access_level < 50) {
            return $this->goHome();
        }
        else {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                try {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', 'Изменения успешно сохранены');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                catch (\Exception $exception){
                    Yii::$app->getSession()->setFlash('error', $exception);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'category' => $this->getCategory(),
                'subject' => $this->getSubject(),
            ]);
        }
    }

    /**
     * Deletes an existing Books model.
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
        else {
            try{
                $this->findModel($id)->delete();
            }
            catch (\Throwable $exception){
                return Yii::$app->getSession()->setFlash('error', $exception);
            }

            return $this->redirect(['index']);
        }
    }

    private function getCategory(){
        $categories = BooksCategories::find()->orderBy(['name' => SORT_ASC])->all();
        $count = count($categories);
        $category = [];
        for($i = 0;$i < $count;$i++){
            $category[$i+1] = $categories[$i]['name'];
        }
        return $category;
    }

    private function getSubject(){
        $subjects = BooksSubjects::find()->orderBy(['name' => SORT_ASC])->all();
        $count = count($subjects);
        $subject = [];
        for($i = 0;$i < $count;$i++){
            $subject[$i+1] = $subjects[$i]['name'];
        }
        return $subject;
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
