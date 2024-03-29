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
use yii\helpers\Url;

class PostsController extends Controller{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update','delete'],
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

         Url::remember();
         return $this->render("index", [
            'dataProvider' => Posts::getDataProvider(),
         ]);

    }

    public function actionCreate(){

         $model = new Posts();
         if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
             return $this->redirect([Url::previous()]);
         }

         return $this->render('create', ['model' => $model,'date' => Yii::$app->getFormatter()->asDateTime(time())]);

    }

    public function actionUpdate($id){

         $model = Posts::getCurrentPost($id);
         if(!empty($model)){
             if(!($model->load(Yii::$app->request->post()) && $model->validate() && $model->save())){
                 return $this->render('update', ['model' => $model,'date' => Yii::$app->getFormatter()->asDateTime(time())]);
             }
         }

         return $this->redirect([Url::previous()]);

    }

    public function actionDelete($id){

         $model = Posts::getCurrentPost($id);
         if(!empty($model)){
              $model->delete();
         }

         return $this->redirect([Url::previous()]);

    }

}

?>
