<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\validators\EmailValidator;
use yii\data\Pagination;
use yii\base\Model;
use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

     public $newRole; // it's contains role from create user page

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
            ['email', 'validateEmail'],
            ['email', 'validateUpdate', 'on' => 'update'],
            ['newRole', 'validateRole', 'on' => 'update'],
            ['email', 'unique', 'message' => 'Such e-mail address already exists!', 'on' => 'create'],   // username
            [['email','username','password','newRole'], 'required'],
            [['username', 'password', 'authKey', 'accessToken','email', 'address', 'birthday', 'phone'], 'string', 'max' => 255],
        ];
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
            'userRole' => 'User Role',
            'postCount' => 'Posts Count',
            'email' => 'E-mail',
            'birthday' => 'Date of Birth',
            'phone' => '',
            'address' => 'Address',
            //'admin' => 'Admin',
        ];
    }

    public function validateEmail(){

         $validator = new EmailValidator();
         if(!$validator->validate($this->email, $error)){
              $this->addError('email', $error);
         }

    }

    public function validateUpdate(){

         $anotherUser = User::find()->where(['email' => $this->email])->one();
         if(!empty($anotherUser)){
              if($anotherUser->id != $this->id){
                   $this->addError('email', 'There is another user which has the same e-mail address!');
              }
         }

    }

    public function validateRole(){

       if($this->id == Yii::$app->user->getId()){ // this is your user record
            $yourRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()));
            if($yourRole != $this->newRole){
                 $this->addError('newRole', 'You cant change your role!');
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

         //$role = Roles::getRoles()[$this->role];
         $auth = YII::$app->authManager;
         $auth->revokeAll($this->id);
         $userRole = $auth->getRole($this->newRole);
         $auth->assign($userRole, $this->id);

         return parent::afterSave($insert, $changedAttributes);

    }

    public function beforeDelete(){

         if(parent::beforeDelete()){
             Comments::deleteAll(['userId' => $this->id]);
             Posts::deleteAll(['userId' => $this->id]);     // deleting all posts by userId
             Friends::deleteAll(['senderId' => $this->id]); // deleting from friends
             Friends::deleteAll(['receiverId' => $this->id]);
             Messages::deleteAll(['senderId' => $this->id]); // deleting from Messages
             Messages::deleteAll(['receiverId' => $this->id]);
             return true;
         }
         else{
              return false;
         }

    }

    // Post
    public function getPosts(){

          return $this->hasMany(Posts::className(), ['userId' => 'id'])->count();

    }

    public function getPostCount(){

         return $this->posts;

    }

    // Messages
    public function getMessages(){

          return $this->hasMany(Messages::className(), ['senderId' => 'id'])->where(['receiverId' => Yii::$app->user->id, 'opened' => 0])->count();

    }

    public function getNewMessages(){

         return $this->messages;

    }

    // Roles
    public function getRole(){

         //return Roles::getRoles();
         return $this->hasOne(Role::className(), ['user_id' => 'id']);

    }

    public function getUserRole(){

         return $this->role->item_name;

    }

    // Friends
    public function getSender(){
         return $this->hasOne(Friends::className(),['receiverId' => 'id'])->where(['senderId' => Yii::$app->user->id]);
    }

    public function getReceiver(){
         return $this->hasOne(Friends::className(),['senderId' => 'id'])->where(['receiverId' => Yii::$app->user->id]);
    }

    public static function getNotAcceptedCount(){
         return Friends::find()->where(['senderId' => Yii::$app->user->id, 'accepted' => 0])->count();
    }

    public static function getWaitingCount(){
         return Friends::find()->where(['receiverId' => Yii::$app->user->id, 'accepted' => 0])->count();
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

    public static function findByEmail($email)
    {
         return User::find()->where(['email' => $email])->one();
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

    public static function getActiveUsers(){

          $query = User::find()->where(['active' => 1])->orderBy("id");
          $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                   'pageSize' => 10,
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

    public function getFriend(){

         return Friends::findFriend($this->id);

    }

    public function getProfilePicture(){

         if(file_exists(Yii::getAlias('@profilePictures')."/".$this->id.".jpg")){
              $resultPicture = Yii::getAlias('@profilePictures')."/".$this->id.".jpg";
         }
         else{
              $resultPicture = Yii::getAlias('@noAvatar');
         }

         return $resultPicture;

    }

    public static function getMyMessages(){

         return Messages::find()->where(['receiverId' => Yii::$app->user->id, 'opened' => 0])->count();

    }

}
