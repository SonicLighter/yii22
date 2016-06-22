<?php

use yii\db\Migration;
use yii\db\Schema;

class m160622_125816_users extends Migration
{
    public function up()
    {
         $this->createTable('users', [
              'id' => Schema::TYPE_PK,
              'username' => Schema::TYPE_STRING,
              'password' => Schema::TYPE_STRING,
              'authKey' => Schema::TYPE_STRING,
              'accessToken' => Schema::TYPE_STRING,
              'admin' => Schema::TYPE_INTEGER,
         ]);
         $this->insert('users', [
              'username' => "admin",
              'password' => "admin",
              'authKey' => "admin",
              'accessToken' => "admin",
              'admin' => "1",
         ]);
         $this->insert('users', [
              'username' => "user",
              'password' => "user",
              'authKey' => "user",
              'accessToken' => "user",
              'admin' => "0",
         ]);
    }

    public function down()
    {
        $this->delete('tempUsers', ['username' => 'admin']);
        $this->delete('tempUsers', ['username' => 'user']);
        $this->dropTable('tempUsers');
        return false;
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
