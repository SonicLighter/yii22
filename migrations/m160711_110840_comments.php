<?php

use yii\db\Migration;

class m160711_110840_comments extends Migration
{
    public function up()
    {
         $this->createTable('comments',[
             'id' => $this->primaryKey(),
             'userId' => $this->integer()->notNull(),
             'postId' => $this->integer()->notNull(),
             'message' => $this->text()->notNull(),
         ]);
         $this->addForeignKey('fk_comments_users', 'comments', 'userId', 'users', 'id');
         $this->addForeignKey('fk_comments_posts', 'comments', 'postId', 'posts', 'id');
    }

    public function down()
    {
         $this->dropForeignKey('fk_comments_users', 'comments');
         $this->dropForeignKey('fk_comments_posts', 'comments');
         $this->dropTable('comments');
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
