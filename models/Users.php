<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property integer $admin
 */
class Users extends \yii\db\ActiveRecord
{

     public $id;
     public $username;
     public $password;
     public $authKey;
     public $accessToken;

     /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
         $result = Users::find()->where(['username' => $username])->count();

         if($result < 1){
              return null;
         }

         $result = Users::find()->where(['username' => $username])->one();
         if (strcasecmp($result->username, $username) === 0) {
             $user = [
               'id' => $result->id,
               'username' => $result->username,
               'password' => $result->password,
               'authKey' => $result->authKey,
               'accessToken' => $result->accessToken
             ];
             return new static($user);
         }

         return null;
         /*
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
        */
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


}
