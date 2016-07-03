<?php

use yii\db\Migration;
use app\models\User;

class m160703_123333_e_mail extends Migration
{
    public function up()
    {
         $this->addColumn('users', 'email', $this->string());
         $userModel = User::find()->all();
         foreach ($userModel as $user) {
              $this->update('users', ['email' => $user->username."@yii.by"], "id=".$user->id);
         }
    }

    public function down()
    {
         $this->dropColumn('users', 'email');
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
