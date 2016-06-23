<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\data\Pagination;

class SiteController extends Controller
{
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    // test
    public function actionSay($target = "World"){
          echo "Hello world!";
         return $this->render("say",["target" => $target]);
    }

    // database
    public function actionDatabase()
    {
         $username = "admin1";
         $result = Users::find()->where(['username' => $username])->count();
         echo "result: ".$result;
         $result = Users::find()->where(['username' => $username])->one();
         echo "<br/>username: ".$result->username;
         /*
         $modelUser = new Users();
         $modelUser->username = "testUser";
         $modelUser->password = "123";
         $modelUser->authKey = "123";
         $modelUser->accessToken = "123";
         $modelUser->admin = "0";
         $modelUser->save();
          echo "Information successful saved!";
          */


          //$id = 3;
          //$result = Users::find()->where(['id' => $id])->one();
          //echo $result->id." - username: ".$result->username." password: ".$result->password." ";

    }

    public function actionUsers(){

         return $this->render("users", [
              'dataProvider' => User::getDataProvider(),
         ]);

    }

}
