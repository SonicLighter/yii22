<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserForm;
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
                        'actions' => ['create'],
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

          $model = new UserForm();
          if($model->load(Yii::$app->request->post()) && $model->validate()){
               $role = Roles::getRoles()[$model->role];
               if(User::createUser($model->name, $model->password, $role)){
                    return Yii::$app->response->redirect(['users/index']);
               }
          }

          return $this->render('create', ['model' => $model, 'roles' => Roles::getRoles()]);

     }

}

?>
