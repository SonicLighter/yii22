<?php

use yii\db\Migration;

class m160628_071439_delete_admin_from_users extends Migration
{
    public function up()
    {
         $this->dropColumn('users', 'admin');
    }

    public function down()
    {
         $this->addColumn('users', 'admin', $this->integer());
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
