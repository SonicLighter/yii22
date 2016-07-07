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
use yii\web\UploadedFile;

class ProfileController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => ['index', 'edit', 'picture', 'search'],
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
         $model->scenario = 'editProfile';
         if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
              return $this->redirect(['profile/index']);
         }

         return $this->render('edit', ['model' => $model]);

    }

    public function actionPicture(){

         $model = Profile::findOne(Yii::$app->user->id);
         $model->scenario = 'editPicture';
         $fileToDelete = $model->profilePicture;
         if(Yii::$app->request->isPost){
              $model->picture = UploadedFile::getInstance($model, 'picture');
              if(isset($model->picture) && $model->uploadPicture() && $model->save()){
                   if($fileToDelete != Yii::getAlias('@noAvatar')){
                        unlink($fileToDelete);
                   }
                   return $this->redirect(['profile/index']);
              }
         }

         return $this->render('picture', ['model' => $model]);

    }

    public function actionSearch(){

         $searchModel = new UserSearch('search');
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('search', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
         ]);

    }

}

?>
