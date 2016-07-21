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
class DefaultController extends Controller
{

     public $layout = 'login';


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

         if (!Yii::$app->user->isGuest) {
              switch (Yii::$app->user->identity->userRole) {
                   case 'admin':
                   case 'moderator':{
                        return $this->redirect(Url::toRoute(['main/index']))->send();
                        break;
                   }
                   default:
                        return $this->redirect(Url::toRoute(['../profile/index', 'id' => Yii::$app->user->id]))->send();
                        break;
              }
         }

         $model = new LoginForm();
         $model->scenario = 'adminpanel';
         if ($model->load(Yii::$app->request->post()) && $model->login()) {
              return $this->redirect(Url::toRoute(['main/index']))->send();
         }
         return $this->render('index', [
             'model' => $model,
         ]);

    }

    public function actionMain(){

         echo 'hello from Default/Main, this action is allowed only for admins and moderators!!!';
         die();

    }



}
