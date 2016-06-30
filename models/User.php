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
            ['username', 'validateUpdate', 'on' => 'update'],
            ['role', 'validateRole', 'on' => 'update'],
            ['username', 'unique', 'message' => 'Such user name already exists!', 'on' => 'create'],
            [['username','password','role'], 'required'],
            [['username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    public function validateUpdate(){

         $anotherUser = User::findByUsername($this->username);
         if(!empty($anotherUser)){
              if($anotherUser->id != $this->id){
                   $this->addError('username', 'There is another user which has the same username!');
              }
         }

    }

    public function validateRole(){

       if($this->id == Yii::$app->user->getId()){ // this is your user record
            $yourRole = Roles::findRoleIndex(Roles::getRoles(), key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())));
            if($yourRole != $this->role){
                 $this->addError('role', 'You cant change your role!');
            }
       }

    }

    public function beforeSave($insert){

         if(!preg_match('/^[a-f0-9]{64}$/', $this->password)){   // if password is not hash
             $this->password = hash('sha256', $this->password);
         }

         return parent::beforeSave($insert);

    }

    public function afterSave($insert, $changedAttributes){

         $role = Roles::getRoles()[$this->role];
         $auth = YII::$app->authManager;
         $auth->revokeAll($this->id);
         $userRole = $auth->getRole($role);
         $auth->assign($userRole, $this->id);

         return parent::afterSave($insert, $changedAttributes);

    }

    public function getPosts(){

          return $this->hasMany(Posts::className(), ['userId' => 'id']);

    }

    public function getPostCount(){

         return count($this->posts);

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
              'sort' => [
                   'attributes' => [
                        'username' => [
                             'asc' => 'username',
                             'desc' => 'username DESC',
                        ],
                   ],
              ],
          ]);

          return $dataProvider;

    }

    public static function isExists($username){

         if(User::find()->where(['username' => $username])->count() > 0){
              return true;   // user already exists
         }

         return false;

    }

}
