<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Roles;
use yii\data\Pagination;

class UsersController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['openUsers'], // admin and moderator
                    ],
                    [
                        'actions' => ['create', 'update','delete'],
                        'allow' => true,
                        'roles' => ['admin'], // admin
                    ],
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

     public function actionIndex(){

          return $this->render("index", [
              'dataProvider' => User::getDataProvider(),
          ]);

     }

     public function actionCreate(){

          $model = new User();
          $model->scenario = 'create'; // using create to validate only for this action
          if($model->load(Yii::$app->request->post()) && $model->validate()){
               $role = Roles::getRoles()[$model->role];
               if(User::createUser($model->username, $model->password, $role)){
                    return Yii::$app->response->redirect(['users/index']);
               }
          }

          return $this->render('create', ['model' => $model, 'roles' => Roles::getRoles()]);

     }

     public function actionUpdate(){

          $id = Yii::$app->request->get('id');
          $user = User::findIdentity($id);
          if(empty($user)){
               return Yii::$app->response->redirect(['users/index']); // no user with such id
          }

          $model = new User();
          if($model->load(Yii::$app->request->post()) && $model->validate()){ // without validate, because there is some problems with user name
               $role = Roles::getRoles()[$model->role];
               if(User::updateUser($id, $model->username, $model->password, $model->authKey, $model->accessToken, $role)){
                    return Yii::$app->response->redirect(['users/index']);
               }
          }

          return $this->render('update', ['model' => $model, 'user' => $user, 'roles' => Roles::getRoles()]);

     }

     public function actionDelete(){

          $request = Yii::$app->request;
          $id = $request->get('id');

          echo $id;
          die();

     }

}

?>
