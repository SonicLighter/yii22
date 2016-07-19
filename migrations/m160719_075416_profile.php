<?php

use yii\db\Migration;
use app\models\User;

class m160719_075416_profile extends Migration
{
    public function up()
    {
         $this->createTable('profile',[
              'id' => $this->primaryKey(),
              'userId' => $this->integer()->notNull(),
              'active' => $this->boolean()->notNull(),
              'birthday' => $this->string()->notNull(),
              'phone' => $this->string()->notNull(),
              'address' => $this->string()->notNull(),
              'commentPermission' => $this->boolean()->notNull(),
         ]);

         $this->addForeignKey('fk_profile_users', 'profile', 'userId', 'users', 'id');

         $users = Users::find()->all();
         foreach ($users as $user) {
              $this->insert('profile',['userId' => $user->id, 'active' => $user->active, 'birthday' => $user->birthday,
                                        'phone' => $user->phone, 'address' => $user->address, 'commentPermission' => $user->commentPermission]);
         }

         $this->dropColumn('users', 'active');
         $this->dropColumn('users', 'birthday');
         $this->dropColumn('users', 'phone');
         $this->dropColumn('users', 'address');
         $this->dropColumn('users', 'commentPermission');

    }

    public function down()
    {
         $this->addColumn('users', 'active', $this->boolean());
         $this->addColumn('users', 'birthday', $this->string());
         $this->addColumn('users', 'phone', $this->string());
         $this->addColumn('users', 'address', $this->string());
         $this->addColumn('users', 'commentPermission', $this->boolean());
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
