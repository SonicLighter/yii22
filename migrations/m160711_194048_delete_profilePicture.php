<?php

use yii\db\Migration;

class m160711_194048_delete_profilePicture extends Migration
{
    public function up()
    {
         $this->dropColumn('users', 'profilePicture');
    }

    public function down()
    {
         $this->addColumn('users', 'profilePicture', $this->string());
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
