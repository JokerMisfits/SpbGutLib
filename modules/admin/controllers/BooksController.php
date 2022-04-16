<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\BooksCategories;
use app\modules\admin\models\BooksHistory;
use app\modules\admin\models\BooksSubjects;
use Yii;
use app\modules\admin\models\Books;
use app\modules\admin\models\BooksSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

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

        if(Yii::$app->user->isGuest == true){
            $this->AccessDenied();
            return $this->goHome();
        }

        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categories = new BooksCategories();
        $subjects = new BooksSubjects();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'subjects' => $subjects,

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
        if(Yii::$app->user->isGuest == true){
            $this->AccessDenied();
            return $this->goHome();
        }

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
            $this->AccessDenied();
            return $this->goHome();
        }
        $model = new Books();
        $model->scenario = Books::SCENARIO_CREATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['name', 'author', 'keywords', 'publisher', 'annotation', 'comment'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('create',['model' => $model,'category' => $this->getCategories(),'subject' => $this->getSubjects()]);
            }
            if($model->count > 0){
                $model->rest = $model->count;
                $date = date("Y");
                if($model->publish_date != null){
                    if($model->date > $model->publish_date){
                        Yii::$app->getSession()->setFlash('error', 'Год издания долженн быть больше либо равен году первой публикации!');
                        $model->date = null;
                        $model->publish_date = null;
                        return $this->render('create',['model' => $model,'category' => $this->getCategories(),'subject' => $this->getSubjects()]);
                    }
                    if(!(is_numeric($model->date) == true && is_numeric($model->publish_date) == true && strlen($model->date) == 4 && strlen($model->publish_date) == 4 && (integer)$model->date > 0 && (integer)$model->publish_date > 0 && (integer)$model->date <= $date && (integer)$model->publish_date <= $date)){
                        Yii::$app->getSession()->setFlash('error', 'Год публикации и издания должен состоять из 4 чисел без пробелов и должен быть <= '.$date.' !');
                        $model->date = null;
                        $model->publish_date = null;
                        return $this->render('create',['model' => $model,'category' => $this->getCategories(),'subject' => $this->getSubjects()]);
                    }
                }
                else{
                    if(!(is_numeric($model->date) == true && strlen($model->date) == 4 && (integer)$model->date > 0 && (integer)$model->date <= $date)){
                        Yii::$app->getSession()->setFlash('error', 'Год публикации и издания должен состять из 4 чисел без пробелов и должен быть <= '.$date.' !');
                        $model->date = null;
                        $model->publish_date = null;
                        return $this->render('create',['model' => $model,'category' => $this->getCategories(),'subject' => $this->getSubjects()]);
                    }
                }
            }
            else{
                Yii::$app->getSession()->setFlash('error', 'Количество книг должно быть больше 0!');
                return $this->redirect(['/admin/books/create']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', 'Книга успешно сохранена.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect(['/admin/books/create']);
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect(['/admin/books/create']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'category' => $this->getCategories(),
            'subject' => $this->getSubjects(),
        ]);
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
            $this->AccessDenied();
            return $this->goHome();
        }
        $model = $this->findModel($id);
        $model->scenario = Books::SCENARIO_UPDATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $oldModel = Books::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', 'Измените данные перед отправкой!');
                return $this->render('update', [
                    'model' => $model,
                    'categories' => $this->getCategories(),
                    'subjects' => $this->getSubjects(),
                ]);
            }
            $attributes = ['name', 'author', 'keywords', 'publisher', 'annotation', 'comment'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('update', [
                    'model' => $model,
                    'categories' => $this->getCategories(),
                    'subjects' => $this->getSubjects(),
                ]);
            }
            if($model->count >= 0){
                $date = date("Y");
                if($model->publish_date != null){
                    if($model->date > $model->publish_date){
                        Yii::$app->getSession()->setFlash('error', 'Год первой публикации должен быть больше либо равен году издания!');
                        return $this->render('update', [
                            'model' => $model,
                            'categories' => $this->getCategories(),
                            'subjects' => $this->getSubjects(),
                        ]);
                    }
                    if(!(is_numeric($model->date) == true && is_numeric($model->publish_date) == true && strlen($model->date) == 4 && strlen($model->publish_date) == 4 && (integer)$model->date > 0 && (integer)$model->publish_date > 0 && (integer)$model->date <= $date && (integer)$model->publish_date <= $date)){
                        Yii::$app->getSession()->setFlash('error', 'Год публикации и издания должен состять из 4 чисел без пробелов и должен быть меньше либо равен '.$date.' !');
                        $model->date = null;
                        $model->publish_date = null;
                        return $this->render('update', [
                            'model' => $model,
                            'categories' => $this->getCategories(),
                            'subjects' => $this->getSubjects(),
                        ]);
                    }
                }
                $command = Yii::$app->db->createCommand();
                $old_count = (new \yii\db\Query())
                    ->select('count')
                    ->from('books')
                    ->where(['id' => $model->id])
                    ->one();
                if($old_count['count'] != $model->count){
                    if ($model->count == 0){
                        $difference = -$old_count['count'];
                    }
                    else{
                        if($old_count['count'] == 0){
                            $difference = $model->count;
                        }
                        else{
                            if($old_count['count'] > $model->count){
                                $difference = -($old_count['count'] - $model->count);
                            }
                            else{
                                $difference = $model->count - $old_count['count'];
                            }

                        }
                    }
                    if($difference != 0){
                        $model->rest = (integer)$model->rest + (integer)$difference;
                        $old_stock = (new \yii\db\Query())
                            ->select('stock')
                            ->from('books')
                            ->where(['id' => $model->id])
                            ->one();
                        if($old_stock['stock'] == 0){
                            if((integer)$model->rest > 0){
                                try {
                                    $command->update('books',
                                        ['stock' => 1], ['id' => $model->id])
                                        ->execute();
                                }
                                catch (\Exception|\Throwable $exception){
                                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                                    return $this->render('update', [
                                        'model' => $model,
                                        'categories' => $this->getCategories(),
                                        'subjects' => $this->getSubjects(),
                                    ]);
                                }
                            }
                            else{
                                Yii::$app->getSession()->setFlash('error', 'Остаток не может быть меньше 0! Закройте активные заявки на данную книги и попробуйте снова.');
                                return $this->redirect(['/admin/books/index']);
                            }
                        }
                        else{
                            if($model->rest < 0){
                                Yii::$app->getSession()->setFlash('error', 'Остаток не может быть меньше 0! Закройте активные заявки на данную книги и попробуйте снова.');
                                return $this->redirect(['/admin/books/index']);
                            }
                            elseif($model->rest == 0){
                                try {
                                    $command->update('books',
                                        ['stock' => 0], ['id' => $model->id])
                                        ->execute();
                                }
                                catch (\Exception|\Throwable $exception){
                                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                                    return $this->render('update', [
                                        'model' => $model,
                                        'categories' => $this->getCategories(),
                                        'subjects' => $this->getSubjects(),
                                    ]);
                                }
                            }
                        }
                    }
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
                        return $this->redirect('/admin/books');
                    }
                }
                catch (\Exception|\Throwable $exception){
                    Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                    return $this->render('update', [
                        'model' => $model,
                        'categories' => $this->getCategories(),
                        'subjects' => $this->getSubjects(),
                    ]);
                }
            }
            else{
                Yii::$app->getSession()->setFlash('error', 'Количество книг должно быть больше 0!');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $this->getCategories(),
            'subjects' => $this->getSubjects(),
        ]);
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
            $this->AccessDenied();
            return $this->goHome();
        }
        else {
            try{
                $model  = $this->findModel($id);
                if($model->count == $model->rest){
                    if($this->findTasks($model->id) == true){
                        $transaction = Yii::$app->db->beginTransaction();
                        if($model->delete()){
                            Yii::$app->getSession()->setFlash('success', 'Книга [' . $model->name . '] успешно удалена.');
                            $transaction->commit();
                            return $this->redirect('/admin/books');
                        }
                        else{
                            Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                            $transaction->rollBack();
                            return $this->redirect('/admin/books');
                        }
                    }
                    else{
                        return $this->redirect('/admin/books');
                    }
                }
                else{
                    Yii::$app->getSession()->setFlash('error', 'Закройте активные заявки на данную книги и попробуйте снова.');
                    return $this->redirect('/admin/books');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                return $this->redirect('/admin/books');
            }
        }
    }

    private function getCategories(){
        $categories = BooksCategories::find()->orderBy(['name' => SORT_ASC])->all();

        $count = count($categories);
        $category = [];
        for($i = 0;$i < $count;$i++){
            $category[$categories[$i]['id']] = $categories[$i]['name'];
        }
        return $category;
    }

    private function getSubjects(){
        $subjects = BooksSubjects::find()->orderBy(['name' => SORT_ASC])->all();
        $count = count($subjects);
        $subject = [];
        for($i = 0;$i < $count;$i++){
            $subject[$subjects[$i]['id']] = $subjects[$i]['name'];
        }
        return $subject;
    }

    private function findTasks($id){
        $model = BooksHistory::find()
            ->where(['book_id' => $id,'active' => 1])
            ->asArray()
            ->one();
        if($model != null){
            Yii::$app->getSession()->setFlash('error', 'Невозможно удалить данную книгу, закройте заявки и попробуйте снова!');
            return false;
        }
        $model = BooksHistory::find()
            ->where(['book_id' => $id])
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
                    ['book_id' => $id,'active' => 0])
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

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
