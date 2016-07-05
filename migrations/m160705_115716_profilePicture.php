<?php

use yii\db\Migration;
use app\models\User;

class m160705_115716_profilePicture extends Migration
{
     public function up()
    {
         $this->addColumn('users', 'profilePicture', $this->string());
         $userModel = User::find()->all();
         foreach ($userModel as $user) {
              $this->update('users', ['profilePicture' => 'images/default/no-avatar.jpg'], "id=".$user->id);
         }
    }

    public function down()
    {
         $this->dropColumn('users', 'profilePicture');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
