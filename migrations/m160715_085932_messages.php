<?php

use yii\db\Migration;

class m160715_085932_messages extends Migration
{
    public function up()
    {
         $this->createTable('messages',[
             'id' => $this->primaryKey(),
             'senderId' => $this->integer()->notNull(),
             'receiverId' => $this->integer()->notNull(),
             'message' => $this->text()->notNull(),
             'opened' => $this->integer()->notNull(),
         ]);
         $this->addForeignKey('fk_messages_senderId', 'messages', 'senderId', 'users', 'id');
         $this->addForeignKey('fk_messages_receiverId', 'messages', 'receiverId', 'users', 'id');
    }

    public function down()
    {
         $this->dropForeignKey('fk_messages_senderId', 'messages');
         $this->dropForeignKey('fk_messages_receiverId', 'messages');
         $this->dropTable('messages');
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
