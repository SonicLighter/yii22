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
          $model->scenario = 'create'; // using create to validate username only for this action
          if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
               User::setRole($model->id, $model->role);
               return $this->redirect(['users/index']);
          }

          return $this->render('create', ['model' => $model, 'roles' => Roles::getRoles()]);

     }

     public function actionUpdate(){

          $id = Yii::$app->request->get('id');
          $model = User::findIdentity($id);
          if(empty($model)){
               return $this->redirect(['users/index']); // no user with such id
          }

          if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
               User::setRole($model->id, $model->role);
               return $this->redirect(['users/index']);
          }

          return $this->render('update', ['model' => $model, 'user' => $model, 'roles' => Roles::getRoles()]);

     }

     public function actionDelete(){

          $id = Yii::$app->request->get('id');
          $model = User::findIdentity($id);
          if(empty($model)){
               return $this->redirect(['users/index']); // no user with such id
          }

          if($model->delete()){
               $auth = YII::$app->authManager;
               $auth->revokeAll($id);
          }

          return $this->redirect(['users/index']);

     }

}

?>
