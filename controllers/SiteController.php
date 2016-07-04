<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Role;
use app\models\Posts;
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
         /*
         $userModel = User::find()->all();
         foreach ($userModel as $user) {
              echo $user->username."<br/>";
         }
         */
         /*
         $user = User::findOne(11);
         print_r($user->getPostCount());
         */
         //Role::getRoles();
         /*$user = User::findOne(11);
         print_r($user->role->item_name);
         */
         //echo count($user->role);
         /*
         $user = User::findOne(11);
         //echo count($user->posts);
         foreach ($user as $u) {
              echo $u->posts->username;
         }
         */
         /*
         $user = User::findOne(11);
         $posts = $user->getPosts()->all();
         //print_r($posts);
         foreach ($posts as $post) {
              echo $post->title;
         }
         */
         /*
         $user = User::findOne(11);
         $posts = $user->getPosts()->with('users')->count();

         $user = User::find()->with('posts')->where(['id' => 11])->all();

         //print_r($user);
         //$user->joinWith(['posts']);

         foreach ($user as $u) {
              echo $u->title."<br/>";
         }
         */
         /*
         echo strlen('b465361ffa25886d97c693b209bd347e600d1b14d397a8e42b7b7c408f32f0a9')."<br/>";
         if(!preg_match('/^[a-f0-9]{64}$/', 'b465361ffa25886d97c693b209bd347e600d1b14d397a8e42b7b7c408f32f0a9')){
              echo "NO!";
         }
         else{
              echo "YES!";
         }
         */
         /*
         $username = "admin1";
         $result = Users::find()->where(['username' => $username])->count();
         echo "result: ".$result;
         $result = Users::find()->where(['username' => $username])->one();
         echo "<br/>username: ".$result->username;
         */
         /*
         $modelUser = new User();
         $modelUser->username = "testUser";
         $modelUser->password = "123";
         $modelUser->authKey = "123";
         $modelUser->accessToken = "123";
         $modelUser->admin = "0";
         $modelUser->save();
          echo "Information successful saved!";
          die();
          */

          //$id = 3;
          //$result = Users::find()->where(['id' => $id])->one();
          //echo $result->id." - username: ".$result->username." password: ".$result->password." ";

    }

}
