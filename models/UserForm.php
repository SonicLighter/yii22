<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UserForm extends Model{

     public $name;
     public $password;
     public $role;

     public function rules(){

          return [
              ['name', 'validateUsername'],
              [['name', 'password', 'role'], 'required'],
          ];

     }

     public function validateUsername(){

          if(User::isExists($this->name)){
               $this->addError('name', 'Such user name already exists!');
          }

     }

}

?>
