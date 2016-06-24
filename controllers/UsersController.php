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

          /*
          if((Yii::$app->user->can('openUsers')) && (Yii::$app->user->can('openRoles'))){
               echo "This user can open USERS and ROLES!";
          }
          else if(Yii::$app->user->can('openUsers')){
               echo "This user can open USERS!";
          }
          else{
               echo "This user can't open anything!";
          }
          die();
          */

          // only for admins
          /*
          if (!isset(Yii::$app->user->identity->admin)){
               return Yii::$app->response->redirect(['site/index']);
          }
          else if(Yii::$app->user->identity->admin != 1){
               return Yii::$app->response->redirect(['site/index']);
          }

          */

          //print_r(Yii::$app->authManager->getRoles(1));
          //echo "<br/>".key(Yii::$app->authManager->getRoles(1));
          //if(empty()){
               //$role = Yii::$app->authManager->getRolesByUser(1)[]->name;
               //echo $role;
          //}
          //die();

          return $this->render("index", [
              'dataProvider' => User::getDataProvider(),
          ]);

     }

}

?>
