<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class Profile extends User{

     public $newPassword;
     public $editPassword = true;
     public $newRole;


     public function __construct(){

          $this->newRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

     }

     public function rules(){

          return [
               ['username', 'required'],
               ['editPassword', 'boolean'],
               ['newPassword', 'string', 'min' => 6],
               ['editPassword', 'validateEditPassword'],
          ];

     }

    public function attributeLabels()
    {
        return [
            'newPassword' => 'New Password',
            'editPassword' => 'Edit Password',
        ];
    }

    public function validateEditPassword(){
         $this->newPassword = trim($this->newPassword);
         if($this->editPassword){
              if(isset($this->newPassword) && (strlen($this->newPassword) != 0)){
                   $this->password = $this->newPassword;    // and then beforeSave add hash
              }
              else{
                   $this->addError('newPassword', 'You can\'t leave new password empty!');
              }
         }
    }



}

?>
