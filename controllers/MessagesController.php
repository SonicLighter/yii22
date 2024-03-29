<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Friends;
use app\models\Role;
use app\models\Posts;
use app\models\Profile;
use app\models\Comments;
use app\models\Messages;
use yii\data\Pagination;
use app\models\search\UserSearch;
use app\models\search\PostsSearch;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class MessagesController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => ['index', 'view', 'add'],
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

         Url::remember();
         $pageType = 'messages';
         $searchModel = new UserSearch($pageType);
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('index', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'pageType' => $pageType,
              'loadPage' => User::getDialogLoading(),
         ]);

    }

    public function actionView($id){

         $modelUser = User::findIdentity($id);
         if(!empty($modelUser) && (Yii::$app->user->id != $id)){
              $model = new Messages();
              $dataProvider = Messages::getUserMessages($id);
              Messages::setMessagesOpened($id);
              return $this->render('view',[
                   'modelUser' => $modelUser,
                   'model' => $model,
                   'dataProvider' => $dataProvider,
                   'loadPage' => Messages::getMessagePages($id),
              ]);
         }

         return $this->redirect(Url::toRoute('profile/errors'));

    }

    public function actionAdd($id){

         $modelUser = User::findIdentity($id);
         if(!empty($modelUser) && (Yii::$app->user->id != $id)){
              $model = new Messages();
              $model->senderId = Yii::$app->user->id;
              $model->receiverId = $id;
              $model->date = Yii::$app->getFormatter()->asDateTime(time());
              $model->opened = 0;
              if(($model->load(Yii::$app->request->post()) && $model->validate() && $model->save())){
                    return $this->redirect(Url::toRoute(['view', 'id' => $id]));
              }
         }

         return $this->redirect(Url::toRoute('profile/errors'));

    }

}

?>
