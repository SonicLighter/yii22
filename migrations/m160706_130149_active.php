<?php

use yii\db\Migration;
use app\models\User;

class m160706_130149_active extends Migration
{
    public function up()
    {
         $this->addColumn('users', 'active', $this->boolean());
         $userModel = User::find()->all();
         foreach ($userModel as $user) {
              $this->update('users', ['active' => false], "id=".$user->id);
         }
    }

    public function down()
    {
         $this->dropColumn('users', 'active');
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
