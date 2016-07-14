<?php

use yii\db\Migration;
use app\models\User;

class m160714_113223_commentPermission extends Migration
{
    public function up()
    {
         $this->addColumn('users', 'commentPermission', $this->boolean());
         $userModel = User::find()->all();
         foreach ($userModel as $user) {
              $this->update('users', ['commentPermission' => true], "id=".$user->id);
         }
    }

    public function down()
    {
         $this->dropColumn('users', 'commentPermission');
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
