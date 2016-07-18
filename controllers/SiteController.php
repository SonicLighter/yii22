<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Friends;
use app\models\Role;
use app\models\Posts;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
                        'allow' => !Yii::$app->user->isGuest,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            */
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


    public function beforeAction($action){

         switch ($action->controller->action->id) {
              case 'index':
              case 'login':{
                   if (!Yii::$app->user->isGuest) {
                     return $this->redirect(Url::toRoute(['profile/index', 'id' => Yii::$app->user->id]))->send();
                   }
                   break;
              }
              default:
                   # code...
                   break;
         }

         return true;

    }

    public function actionIndex()
    {

        $model = new User();
        //$model->scenario = 'registration';
        $model->active = 0;
        $model->commentPermission = 1;
        $model->newRole = 'user';
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            return $this->redirect(['site/login']);
        }

        return $this->render('index',[
             'model' => $model,
        ]);

    }

    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
            // return $this->redirect(Url::toRoute(['profile/index', 'id' => Yii::$app->user->id]));
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
         //echo Posts::getLoadCount(11);
         /*
         $arraySender = ArrayHelper::getColumn(Friends::find()->where(['senderId' => Yii::$app->user->id])->all(), 'receiverId');
         $arrayReceiver = ArrayHelper::getColumn(Friends::find()->where(['receiverId' => Yii::$app->user->id])->all(), 'senderId');
         print_r(Friends::find()->select('id')->all());
         die();
         */
         /*
         $friends = Friends::findFriends(11);
         foreach ($friends as $friend) {
              if($friend->senderId == 11){
                   echo '<br/>Friend ID: '.$friend->receiverId;
              }
              else{
                   echo '<br/>Friend ID: '.$friend->senderId;
              }
         }
         */
         /*$user = User::findOne(11);
         $friends = $user->friends;
         foreach ($friends as $friend) {
              if($friend->senderId == $user->id){
                   echo '<br/>Friend ID: '.$friend->receiverId;
              }
              else{
                   echo '<br/>Friend ID: '.$friend->senderId;
              }
         }
         */
         /*
         echo Yii::getAlias('@profilePictures');
         die();
         */
         /*
         $auth = YII::$app->authManager;
         $userModel = User::findOne(11);
         $userRole = $auth->getRole('admin');
         $auth->assign($userRole, $userModel->id);
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
