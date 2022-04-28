<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Books;
use app\modules\admin\models\People;
use Yii;
use app\modules\admin\models\BooksHistory;
use app\modules\admin\models\BooksHistorySearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * BooksHistoryController implements the CRUD actions for BooksHistory model.
 */
class BooksHistoryController extends AppAdminController
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
     * Lists all BooksHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $book = new Books();
        $active = new BooksHistory();

        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'book' => $book,
            'active' => $active,
            'count' => count(BooksHistory::find()->where(['active' => 0])->all()),
        ]);
    }

    /**
     * Displays a single BooksHistory model.
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

        $model = $this->findModel($id);
        $book = $this->getBook($model->book_id);
        return $this->render('view', [
            'model' => $model,
            'book' => $book->name,
        ]);
    }

    /**
     * Creates a new BooksHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BooksHistory();
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['comment', 'count'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('create', ['model' => $model, 'books' => $this->getBooks(), 'people' => $this->getPeople()]);
            }
            $db = Yii::$app->db;
            $user = $model->user_id;
            $book_id = $model->book_id;
            if($model->count < 1){
                Yii::$app->getSession()->setFlash('error', 'Количество должно быть больше 0!');
                return $this->render('create', [
                    'model' => $model,
                    'books' => $this->getBooks(),
                    'people' => $this->getPeople(),
                ]);
            }
            $rest = $db->createCommand("SELECT rest FROM books WHERE id= $book_id")->queryOne();
            if((integer)$rest['rest'] < $model->count){
                Yii::$app->getSession()->setFlash('error', 'Недостаточно книг, осталось: '.$rest['rest']);
                return $this->render('create', [
                    'model' => $model,
                    'books' => $this->getBooks(),
                    'people' => $this->getPeople(),
                ]);
            }
            $newRest = $rest['rest'] - $model->count;
            try {
                $currentBooks = $db->createCommand("SELECT books FROM people WHERE id= $user")->queryOne();
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
            }
            if($currentBooks['books'] == null || $currentBooks['books'] == ''){
                $books = (integer)$model->book_id.'{'.(integer)$model->count.'}';
            }
            else{
                $books = explode(',', $currentBooks['books']);
                $books[count($books)+1] = (integer)$model->book_id.'{'.(integer)$model->count.'}';
                $books = implode(',',$books);
            }
            $model->date_from = date('d.m.Y H:i:s');
            $oldStock = $db->createCommand("SELECT stock FROM books WHERE id = $book_id")->queryOne();
            $transaction = $db->beginTransaction();
            try {
                if($model->save()){
                    $db->createCommand()->update('people',
                        ['books' => $books], ['id' => $model->user_id])->execute();
                    $db->createCommand()->update('books',
                        ['rest' => $newRest], ['id' => $model->book_id])->execute();
                    if($newRest == 0){
                        $db->createCommand()->update('books',
                            ['stock' => 0], ['id' => $model->book_id])->execute();
                    }
                    elseif($oldStock['stock'] == 0){
                        $db->createCommand()->update('books',
                            ['stock' => 1], ['id' => $model->book_id])->execute();
                    }
                    Yii::$app->getSession()->setFlash('success', 'Заявка успешно сохранена.');
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-history');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error', $exception->getMessage());
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'books' => $this->getBooks(),
                    'people' => $this->getPeople(),
                ]);
            }
        }


        return $this->render('create', [
            'model' => $model,
            'books' => $this->getBooks(),
            'people' => $this->getPeople(),
        ]);
    }

    /**
     * Updates an existing BooksHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $attributes = ['comment', 'count'];
            if($this->checkWhiteSpaces($model, (array)$attributes) == false){
                return $this->render('update', ['model' => $model, 'books' => $this->getBooks(), 'people' => $this->getPeople()]);
            }
            $oldModel = BooksHistory::find()->where(['id' => $model->id])->one();
            if($model->toArray() == $oldModel->toArray()){
                Yii::$app->getSession()->setFlash('error', 'Измените данные перед отправкой!');
                return $this->render('update', [
                    'model' => $model,
                    'books' => $this->getBooks(),
                    'people' => $this->getPeople(),
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
                    return $this->redirect('/admin/books-history');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error',$exception->getMessage());
                return $this->render('update', [
                    'model' => $model,
                    'books' => $this->getBooks(),
                    'people' => $this->getPeople(),
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'books' => $this->getBooks(),
            'people' => $this->getPeople(),
        ]);
    }

    /**
     * Deletes an existing BooksHistory model.
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
        if($model->active == 1){
            Yii::$app->getSession()->setFlash('error','Нельзя удалять активную запись!');
            return $this->redirect('/admin/books-history');
        }
        else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->delete()){
                    Yii::$app->getSession()->setFlash('success', 'Заявка успешно удалена.' );
                    $transaction->commit();
                    return $this->redirect('/admin/books-history');
                }
                else{
                    Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                    $transaction->rollBack();
                    return $this->redirect('/admin/books-history');
                }
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error',$exception->getMessage());
                return $this->redirect('/admin/books-history');
            }
        }
    }
    /**
     * Deletes an existing BooksHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionClose($id){
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 50){
            $this->AccessDenied();
            return $this->goHome();
        }

        $db = Yii::$app->db;
        $model = $this->findModel($id);
        $user_id = $model->user_id;
        $book_id = $model->book_id;
        $rest = $db->createCommand("SELECT rest FROM books WHERE id= $book_id")->queryOne();
        $stock = $db->createCommand("SELECT stock FROM books WHERE id= $book_id")->queryOne();
        $newRest = $rest['rest'] + $model->count;
        $books = $db->createCommand("SELECT books FROM people WHERE id = $user_id")->queryOne();
        $books = explode(',',$books['books']);
        $count = count($books);
        for($i = 0;$i < $count;$i++){
            if($books[$i] == $model->book_id.'{'.$model->count.'}'){
                unset($books[$i]);
                break;
            }
        }
        $books = implode(',',$books);
        if($books == ''){
            $books = null;
        }
        $model->active = 0;
        $model->date_end = date('d.m.Y H:i:s');
        $transaction = $db->beginTransaction();
        try {
            $db->createCommand()->update('books',
                ['rest' => $newRest], ['id' => $book_id])->execute();
            if($stock['stock'] == 0){
                $db->createCommand()->update('books',
                    ['stock' => 1], ['id' => $book_id])->execute();
            }
            $db->createCommand()->update('people',
                ['books' => $books], ['id' => $user_id])->execute();
            if($model->save()){
                Yii::$app->getSession()->setFlash('success','Заявка успешно закрыта.');
                $transaction->commit();
                return $this->redirect(['/admin/books-history']);
            }
            else{
                Yii::$app->getSession()->setFlash('error', print_r($model->errors,true));
                $transaction->rollBack();
                return $this->redirect('/admin/books-history');
            }
        }
        catch (\Exception|\Throwable $exception){
            Yii::$app->getSession()->setFlash('error',$exception->getMessage());
            $transaction->rollBack();
        }
        return $this->redirect(['/admin/books-history']);
    }

    public function actionActive(){
        if(!isset(Yii::$app->user->identity->access_level) || Yii::$app->user->identity->access_level < 100){
            $this->AccessDenied();
            return $this->goHome();
        }

        if(Yii::$app->request->post()){
            try {
                $count = BooksHistory::find()
                    ->where('active = 0')
                    ->all();
                $count = count($count);
                $active = BooksHistory::findOne(['active' => '0']);
                if($active == null){
                    throw new \Exception('Отсутствуют неактивные записи!');
                }
                BooksHistory::deleteAll(['active' => '0']);
                Yii::$app->getSession()->setFlash('success',"Успешно удалено $count записей.");
            }
            catch (\Exception|\Throwable $exception){
                Yii::$app->getSession()->setFlash('error',$exception->getMessage());
            }
            return $this->redirect(['/admin/books-history']);
        }
        else{
            Yii::$app->getSession()->setFlash('error',"Allow only request method POST");
            return $this->redirect(['/admin/books-history']);
        }

    }

    private function getBook($id){
        $book = Books::find()
            ->where(['id' => $id])
            ->one();
        return $book;
    }

    private function getBooks(){
        $books = Books::find()->all();
        $count = count($books);
        $names = [];
        for($i = 0;$i < $count;$i++){
            $names[$books[$i]['id']] = $books[$i]['name'];
        }
        return $names;
    }
    private function getPeople(){
        $people = People::find()->all();
        $count = count($people);
        $names = [];
        for($i = 0;$i < $count;$i++){
            $names[$people[$i]['id']] = $people[$i]['surname'] . ' ' . $people[$i]['name'] . ' ' . $people[$i]['middle_name'] . ' | Номер пропуска: ' . $people[$i]['pass_number'];
        }
        return $names;
    }

    /**
     * Finds the BooksHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BooksHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BooksHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }
}
