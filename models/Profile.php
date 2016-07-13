<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Profile extends User{

     public $newPassword;
     public $editPassword = true;
     public $newRole;
     public $picture;
     public $dob;
     //public $activeNew;


     public function __construct(){

          if(!file_exists(Yii::getAlias('@profilePictures'))){     // create images/profile directory to store profile pictures
               FileHelper::createDirectory(Yii::getAlias('@profilePictures'), '0777');
          }

          $this->newRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

     }

     public function rules(){

          return [
               ['dob', 'validateDob', 'on' => 'profileInfo'],
               ['username', 'required', 'on' => 'editProfile'],
               ['editPassword', 'boolean', 'on' => 'editProfile'],
               ['active', 'boolean', 'on' => 'editProfile'],
               ['newPassword', 'string', 'on' => 'editProfile'],
               ['editPassword', 'validateEditPassword', 'on' => 'editProfile'],
               //['picture', 'validateFileName', 'on' => 'editPicture'],
               [['picture'], 'file', 'extensions' => 'png, jpg', 'on' => 'editPicture'],
               ['dob', 'required', 'on' => 'profileInfo'],
               [['dob'], 'string', 'max' => 255],
          ];

     }

    public function attributeLabels()
    {
        return [
            'newPassword' => 'New Password',
            'editPassword' => 'Edit Password',
            'active' => 'Press to change your account status',
            'dob' => 'Date of Birth',
        ];
    }

    public function validateDob($attribute){

         $this->birthday = $this->dob;

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
