<?php

use yii\db\Migration;

class m160629_064651_posts extends Migration
{
    public function up()
    {
         $this->createTable('posts',[
             'id' => $this->primaryKey(),
             'userId' => $this->integer()->notNull();
             'title' => $this->string()->notNull();
             'description' => $this->text()->notNull();
             'text' => $this->text()->notNull();

         ]);
    }

    public function down()
    {
         $this->dropTable('posts');
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
