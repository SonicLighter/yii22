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

         $adminPassword = hash("sha256", "admin");
         $this->insert('users', [
              'username' => "admin",
              'password' => $adminPassword,
              'authKey' => "admin",
              'accessToken' => "admin",
              'admin' => "1",
         ]);

         $userPassword = hash("sha256", "user");
         $this->insert('users', [
              'username' => "user",
              'password' => $userPassword,
              'authKey' => "user",
              'accessToken' => "user",
              'admin' => "0",
         ]);

         $moderPassword = hash("sha256", "moder");
         $this->insert('users', [
              'username' => "moder",
              'password' => $moderPassword,
              'authKey' => "moder",
              'accessToken' => "moder",
              'admin' => "0",
         ]);
    }

    public function down()
    {
        $this->dropTable('users');//
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
