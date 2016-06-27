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
              [['name', 'password', 'role'], 'required'],
          ];

     }

}

?>
