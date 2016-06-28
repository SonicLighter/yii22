<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

     public $role;
     //public static $adminLevel; // 0 - user, 1 - moder, 2 -admin

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'unique', 'message' => 'Such user name already exists!', 'on' => 'create'],
            [['username','password','role'], 'required'],
            [['username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert){

         if(!preg_match('/^[a-f0-9]{64}$/', $this->password)){   // if password is not hash
             $this->password = hash('sha256', $this->password);
         }

         return parent::beforeSave($insert);

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            //'admin' => 'Admin',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
         return User::find()->where(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
         return User::find()->where(['accessToken' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
         return User::find()->where(['username' => $username])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === hash("sha256",$password);
    }

    public static function getDataProvider(){

          $query = User::find()->orderBy("id");

          $dataProvider = new ActiveDataProvider([
              'query' => $query,
          ]);

          return $dataProvider;

    }

    public static function isExists($username){

         if(User::find()->where(['username' => $username])->count() > 0){
              return true;   // user already exists
         }

         return false;

    }

    public static function setRole($idUser, $idRole){

         $role = Roles::getRoles()[$idRole];
         $auth = YII::$app->authManager;
         $auth->revokeAll($idUser);
         $userRole = $auth->getRole($role);
         $auth->assign($userRole, $idUser);

    }

    /*
    public static function createUser($name, $password, $role){

         // create user
         $modelUser = new User();
         $modelUser->username = $name;
         $modelUser->password = hash("sha256", $password);
         $modelUser->authKey = "0";
         $modelUser->accessToken = "0";
         $modelUser->role = $role;
         $modelUser->save();

         $currentUser = User::find()->select('id')->where(['username' => $name])->one();

         // set role
         $auth = YII::$app->authManager;
         $userRole = $auth->getRole($role);
         $auth->assign($userRole, $currentUser->id);

         return true;

    }
*/
     /*
    public static function updateUser($id, $username, $password, $authKey, $accessToken, $role){

         // update user
         $modelUser = User::findIdentity($id);
         $modelUser->username = $username;
         $modelUser->password = $password;
         $modelUser->authKey = $authKey;
         $modelUser->accessToken = $accessToken;
         $modelUser->role = $role;
         $modelUser->save();

         // set role
         $auth = YII::$app->authManager;
         $auth->revokeAll($id);
         $userRole = $auth->getRole($role);
         $auth->assign($userRole, $id);

         return true;

    }
    */


}
