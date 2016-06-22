<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $admin;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
            'admin' => 'admin',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
         $count = Users::find()->where(['id' => $id])->count();
         if($count != 1){
              return null;
         }
         $result = Users::find()->where(['id' => $id])->one();
         if($result->id == $id){
              foreach (self::$users as $user) {
                   $user['id'] = $result->id;
                   $user['username'] = $result->username;
                   $user['password'] = $result->password;
                   $user['authKey'] = $result->authKey;
                   $user['accessToken'] = $result->accessToken;
                   $user['admin'] = $result->admin;
              }
              return new static($user);
         }

         return null;
        /*
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        */
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
         $count = Users::find()->where(['accessToken' => $token])->count();
         if($count != 1){
              return null;
         }
         $result = Users::find()->where(['accessToken' => $token])->one();
         if($result->accessToken === $token){
              foreach (self::$users as $user) {
                   $user['id'] = $result->id;
                   $user['username'] = $result->username;
                   $user['password'] = $result->password;
                   $user['authKey'] = $result->authKey;
                   $user['accessToken'] = $result->accessToken;
                   $user['admin'] = $result->admin;
              }
              return new static($user);
         }

         return null;
        /*
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
        */
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
         $count = Users::find()->where(['username' => $username])->count();
         if($count != 1){
              return null;
         }
         $result = Users::find()->where(['username' => $username])->one();
         if(strcasecmp($result->username, $username) === 0){
              foreach (self::$users as $user) {
                   $user['id'] = $result->id;
                   $user['username'] = $result->username;
                   $user['password'] = $result->password;
                   $user['authKey'] = $result->authKey;
                   $user['accessToken'] = $result->accessToken;
                   $user['admin'] = $result->admin;
              }
              return new static($user);
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
