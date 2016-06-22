<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

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
            [['admin'], 'integer'],
            [['username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 30],
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
            'admin' => 'Admin',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
         $result = User::find()->where(['id' => $id])->one();
         if(!empty($result)){
             return $result;
         }
         return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
         $result = User::find()->where(['accessToken' => $token])->one();
         if(!empty($result)){
              if(strcasecmp($result->accessToken, $token) === 0){
                   return $result;
              }
         }
         return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
         $result = User::find()->where(['username' => $username])->one();
         if(!empty($result)){
              if(strcasecmp($result->username, $username) === 0){
                   return $result;
              }
         }
         return null;
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
        return $this->password === $password;
    }
}
