<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() : string
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()){
                return $this->goBack();
            }
            else{
                $model->password = null;
                return $this->render('login', [
                    'model' => $model,
                ]);
            }

        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact($subjectId = null)
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $subjectName = $this->getSubjects();
            $model->subject = $subjectName[$model->subject];
            if($model->contact(Yii::$app->params['adminEmail'])){
                Yii::$app->session->setFlash('contactFormSubmitted');
            }
            return $this->refresh();
        }
        if(isset($subjectId) && $subjectId != null){
            return $this->render('contact', [
                'model' => $model,
                'subjects' => $this->getSubjects(),
                'selected' => $subjectId,
            ]);
        }
        else{
            return $this->render('contact', [
                'model' => $model,
                'subjects' => $this->getSubjects(),
                'selected' => null,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        if(Yii::$app->user->isGuest || (isset(Yii::$app->user->identity->access_level) && Yii::$app->user->identity->access_level < 50)){
            $this->AccessDenied();
            return $this->goHome();
        }
        return $this->render('about', [
            'admins' => $this->getAdmins(),
            ]);

    }

    /**
     * Displays update page.
     *
     * @return mixed
     */
    public function actionUpdate(){
        if(Yii::$app->user->isGuest){
            $this->AccessDenied();
            return $this->goHome();
        }
        return $this->render('update');
    }

    private function getAdmins(): array{
        return (new \yii\db\Query())
            ->select('name,surname,middle_name,email')
            ->from('accounts')
            ->where(['access_level' => 100])
            ->all();
    }

    private function getSubjects(): array{
        return ['Получение аккаунта','Сообщение об ошибке'];
    }
}
