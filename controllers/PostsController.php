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
use app\models\Posts;
use yii\data\Pagination;

class PostsController extends Controller{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'], // admin and moderator
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
            'dataProvider' => Posts::getDataProvider(),
         ]);

    }

    public function actionCreate(){

         $model = new Posts();
         if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
              return $this->render("index", [
                'dataProvider' => Posts::getDataProvider(),
             ]);
         }

         return $this->render('create', ['model' => $model,'date' => Yii::$app->getFormatter()->asDateTime(time())]);

    }

}

?>
