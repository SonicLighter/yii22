<?php

use yii\db\Migration;

class m160718_073422_messages_date extends Migration
{
    public function up()
    {
         $this->addColumn('messages', 'date', $this->string()->notNull());
    }

    public function down()
    {
         $this->dropColumn('messages', 'date');
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
