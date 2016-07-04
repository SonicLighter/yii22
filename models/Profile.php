<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class Profile extends Model{

     public $username;
     public $newPassword;
     public $editPassword = true;


     public function rules(){

          return [
               [['username', 'newPassword'], 'required'],
               ['editPassword', 'boolean'],
          ];

     }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'newPassword' => 'New Password',
            'editPassword' => 'Edit Password',
        ];
    }



}

?>
