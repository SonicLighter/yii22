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
use yii\data\Pagination;
use app\models\search\UserSearch;

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
                    [
                        'actions' => ['create', 'update','delete'],
                        'allow' => true,
                        'roles' => ['admin'], // admin
                    ],
                    [
                         'actions' => ['profile'],
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

          $searchModel = new UserSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->get());
          $roles = Role::getRoles();

          return $this->render("index", [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
              'roles' => $roles,
          ]);

     }

     public function actionCreate(){

          $model = new User();
          $model->scenario = 'create'; // using create to validate username only for this action
          $model->profilePicture = 'images/default/no-avatar.jpg';
          $model->active = 0;
          if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
               return $this->redirect(['users/index']);
          }

          return $this->render('create', ['model' => $model, 'roles' => Role::getRoles()]);

     }

     public function actionUpdate($id){

          $model = User::findIdentity($id);
          $model->scenario = 'update'; // using update to validate username in own validator
          if(empty($model)){
               return $this->redirect(['users/index']); // no user with such id
          }

          //$model->role = Roles::findRoleIndex(Roles::getRoles(), key(Yii::$app->authManager->getRolesByUser($id)));
          $model->newRole = $model->role->item_name;
          if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
               return $this->redirect(['users/index']);
          }

          return $this->render('update', ['model' => $model, 'user' => $model, 'roles' => Role::getRoles()]);

     }

     public function actionDelete($id){

          $model = User::findIdentity($id);
          if(empty($model) || ($id == Yii::$app->user->getId())){
               return $this->redirect(['users/index']); // no user with such id
          }

          if($model->delete()){
               $auth = YII::$app->authManager;
               $auth->revokeAll($id);
          }

          return $this->redirect(['users/index']);

     }

     /*
     public function actionProfile(){

          $model = new EditUser();

          if($model->load(Yii::$app->request->post()) && $model->validate()){

          }

          return $this->render('profile', ['model' => $model]);

     }
     */

}

?>
