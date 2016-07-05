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
use app\models\Profile;
use yii\data\Pagination;
use app\models\search\UserSearch;

class ProfileController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => ['index','edit'],
                         'allow' => !Yii::$app->user->isGuest,
                         'roles' => ['@'],
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

         return $this->render('index');

    }

    public function actionEdit(){

         $model = Profile::findOne(Yii::$app->user->id);
         if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
              return $this->redirect(['profile/index']);
         }

         return $this->render('edit', ['model' => $model]);

    }

}

?>
