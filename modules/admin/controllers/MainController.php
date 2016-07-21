<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\Url;

/**
 * Default controller for the `admin` module
 */
class MainController extends Controller
{

     public function behaviors()
     {
         return [
            'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                     [
                          'actions' => ['index'],
                          'allow' => !Yii::$app->user->isGuest,
                          'roles' => ['@'],
                     ],
                 ],
            ],
         ];
     }

     public function actionIndex(){

          return $this->render('index');

     }

}

?>
