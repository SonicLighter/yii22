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
use yii\data\Pagination;
use app\models\search\UserSearch;
use app\models\search\PostsSearch;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
//use bupy7\bbcode\BBCodeBehavior;

class ProfileController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                         'actions' => ['index', 'edit', 'picture', 'search', 'friends', 'invite', 'remove', 'accept', 'requests', 'waiting','errors', 'deletecomment', 'comment'],
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

    public function actionIndex($id){
         //throw new NotFoundHttpException('User does not exist!');
         if(is_numeric($id)){
              $model = User::findIdentity($id);
              if(!empty($model)){
                   Url::remember();
                   $searchModel = new PostsSearch($id);
                   $dataProvider = $searchModel->search(Yii::$app->request->get());
                   return $this->render('index',[
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'notAcceptedCount' => User::getNotAcceptedCount(),
                        'waitingCount' => User::getWaitingCount(),
                        'model' => $model,
                   ]);
              }
         }
         return $this->redirect('errors');

    }

    public function actionEdit(){

         $model = Profile::findOne(Yii::$app->user->id);
         $model->scenario = 'editProfile';
         if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
              return $this->redirect([Url::previous()]);
         }

         return $this->render('edit', ['model' => $model]);

    }

    public function actionPicture(){

         $model = Profile::findOne(Yii::$app->user->id);
         $model->scenario = 'editPicture';
         $fileToDelete = $model->profilePicture;
         if(Yii::$app->request->isPost){
              $model->picture = UploadedFile::getInstance($model, 'picture');
              $model->picture->saveAs(Yii::getAlias('@profilePictures').'/'.$model->id.'.jpg');
              /*
              if(isset($model->picture) && $model->uploadPicture() && $model->save()){
                   if($fileToDelete != Yii::getAlias('@noAvatar')){
                        unlink($fileToDelete);
                   }
              }
              */
         }

         return $this->redirect(['profile/edit']);

    }

    public function actionSearch(){

         Url::remember();
         $pageType = 'search';
         $searchModel = new UserSearch($pageType);
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('search', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'pageType' => $pageType,
         ]);

    }

    public function actionFriends(){

         Url::remember();
         $pageType = 'friends';
         $searchModel = new UserSearch($pageType);
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('search', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'pageType' => $pageType,
         ]);

    }

    public function actionRequests(){

         Url::remember();
         $pageType = 'requests';
         $searchModel = new UserSearch($pageType);
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('search', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'pageType' => $pageType,
         ]);

    }

    public function actionWaiting(){

         Url::remember();
         $pageType = 'waiting';
         $searchModel = new UserSearch($pageType);
         $dataProvider = $searchModel->search(Yii::$app->request->get());

         return $this->render('search', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'pageType' => $pageType,
         ]);

    }

    public function actionInvite($id){

         if(is_numeric($id) && empty(Friends::findFriend($id)) && (Yii::$app->user->id != $id)){
              $newFriend = new Friends();
              $newFriend->senderId = Yii::$app->user->id;
              $newFriend->receiverId = $id;
              $newFriend->accepted = 0;
              if($newFriend->save()){
                   return $this->redirect([Url::previous()]);
              }
         }

         return $this->redirect('errors');

    }

    public function actionRemove($id){
         if(is_numeric($id)){
              $removeFriend = Friends::findFriend($id);
              if(!empty($removeFriend)){   // user with such $id exists and we can remove him from friends
                   if($removeFriend->delete()){
                        return $this->redirect([Url::previous()]);
                   }
              }
         }

         return $this->redirect('errors');

    }

    public function actionAccept($id){
          if(is_numeric($id)){
              $acceptFriend = Friends::findFriend($id);
              if(!empty($acceptFriend) && ($acceptFriend->senderId != Yii::$app->user->id)){ // if you are sender, then you can't accept by get[]
                   $acceptFriend->accepted = 1;
                   if($acceptFriend->save()){
                        return $this->redirect([Url::previous()]);
                   }
              }
          }

         return $this->redirect('errors');

    }

    public function actionComment($id){

         $modelPosts = Posts::find()->where(['id' => $id])->one();
         if(!empty($modelPosts)){
              $model = new Comments();
              $model->userId = Yii::$app->user->id;
              $model->postId = $id;
              if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
                   return $this->redirect([Url::previous()]);
              }

              return $this->render('comment', ['model' => $model, 'modelPosts' => $modelPosts]);
         }

         return $this->redirect('errors');

    }

    public function actionDeletecomment($id){
         if(is_numeric($id)){
              $removeComment = Comments::find()->where(['id' => $id, 'userId' => Yii::$app->user->id])->one();
              if(!empty($removeComment)){
                   if($removeComment->delete()){
                        return $this->redirect([Url::previous()]);
                   }
              }
         }

         return $this->redirect('errors');

    }

    public function actionErrors(){

         return $this->render('errors');

    }

}

?>
