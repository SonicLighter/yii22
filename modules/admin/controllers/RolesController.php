<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Role;
use yii\data\Pagination;

class RolesController extends Controller{

    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['openRoles'], // admin and moderator
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

         return $this->render('index', [
              'dataProvider' => Role::getDataProvider(),
         ]);

    }

    public function actionCreate(){

         $model = new Role();
         $model->scenario = 'create';
         if($model->load(Yii::$app->request->post()) && $model->validate()){
              if($role = Yii::$app->authManager->createRole($model->item_name)){
                   Yii::$app->authManager->add($role);
                   return $this->redirect(['roles/index']);
              }
         }

         return $this->render('create', [
              'model' => $model,
         ]);

    }

    public function actionDelete($item_name){

         $auth = YII::$app->authManager;
         $role = $auth->getRole($item_name);
         if(!empty($role)){

         }

         return $this->redirect('index');

    }

}

?>
