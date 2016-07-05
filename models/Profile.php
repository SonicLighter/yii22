<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\FileHelper;

class Profile extends User{

     public $newPassword;
     public $editPassword = true;
     public $newRole;
     public $picture;


     public function __construct(){

          if(!file_exists('images/profile')){     // create images/profile directory to store profile pictures
               FileHelper::createDirectory('images/profile', '0777');
          }

          $this->newRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

     }

     public function rules(){

          return [
               ['username', 'required'],
               ['editPassword', 'boolean'],
               ['newPassword', 'string', 'min' => 6],
               ['editPassword', 'validateEditPassword'],
               [['picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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


    public static function getRandomFileName($path, $extension){

          do {
               //$name = md5(microtime().rand(0, 9999));
               $name = uniqid().rand(0, 9999);
               $file = $path.$name.'.'.$extension;
          } while (file_exists($file));

          return $file;

    }

    public function uploadPicture(){

         //if($this->validate()){
              $fileName = Profile::getRandomFileName('images/profile/', $this->picture->extension);
             // echo $fileName;
             // die();
              //echo $fileName.' extension: '.$this->profilePicture->extension;
              //die();
              $this->picture->saveAs($fileName);
              $this->picture = "";
              $this->profilePicture = $fileName;

              return true;
         /*}
         else{
              return false;
         }
         */

    }

}

?>
