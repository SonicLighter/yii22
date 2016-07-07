<?php

use yii\db\Migration;

class m160707_115154_friends extends Migration
{
    public function up()
    {
         $this->createTable('friends',[
             'senderId' => $this->primaryKey(),
             'receiverId' => $this->integer()->notNull(),
             'accepted' => $this->integer()->notNull(),
         ]);
         $this->addForeignKey('senderId', 'friends', 'senderId', 'users', 'id');
         $this->addForeignKey('receiverId', 'friends', 'receiverId', 'users', 'id');
    }

    public function down()
    {
         $this->dropForeignKey('senderId', 'friends');
         $this->dropForeignKey('receiverId', 'friends');
         $this->dropTable('friends');
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
