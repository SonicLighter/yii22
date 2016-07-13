<?php

use yii\db\Migration;

class m160713_155336_extendInfo extends Migration
{
    public function up()
    {
         $this->addColumn('users', 'birthday', $this->string());
         $this->addColumn('users', 'phone', $this->string());
         $this->addColumn('users', 'address', $this->string());
    }

    public function down()
    {
         $this->dropColumn('users', 'birthday');
         $this->dropColumn('users', 'phone');
         $this->dropColumn('users', 'address');
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
