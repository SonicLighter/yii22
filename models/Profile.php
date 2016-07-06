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
     //public $activeNew;


     public function __construct(){

          if(!file_exists(Yii::getAlias('@profilePictures'))){     // create images/profile directory to store profile pictures
               FileHelper::createDirectory(Yii::getAlias('@profilePictures'), '0777');
          }

          $this->newRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

     }

     public function rules(){

          return [
               ['username', 'required', 'on' => 'editProfile'],
               ['editPassword', 'boolean', 'on' => 'editProfile'],
               ['active', 'boolean', 'on' => 'editProfile'],
               ['newPassword', 'string', 'min' => 6, 'on' => 'editProfile'],
               ['editPassword', 'validateEditPassword', 'on' => 'editProfile'],
               //['picture', 'validateFileName', 'on' => 'editPicture'],
               [['picture'], 'file', 'extensions' => 'png, jpg', 'on' => 'editPicture'],
          ];

     }

    public function attributeLabels()
    {
        return [
            'newPassword' => 'New Password',
            'editPassword' => 'Edit Password',
            'active' => 'Press to change your account status',
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

    /*
    public function validateFileName(){
         //echo "asd";
         //die();
         if(!isset($this->picture)){
             $this->addError('picture', 'You can\'t leave this field empty!');
         }

    }
    */

    public static function getRandomFileName($path, $extension){

          do {
               $name = uniqid().rand(0, 9999);
               $file = $path.'/'.$name.'.'.$extension;
          } while (file_exists($file));

          return $file;

    }

    public function uploadPicture(){

         if($this->validate()){
              $fileName = Profile::getRandomFileName(Yii::getAlias('@profilePictures'), $this->picture->extension);
              $this->picture->saveAs($fileName);
              $this->picture = "";
              $this->profilePicture = $fileName;
              return true;
         }
         else{
              return false;
         }

    }

}

?>
