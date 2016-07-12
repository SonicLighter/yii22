<?php

use yii\db\Migration;

class m160712_124212_postChange extends Migration
{
    public function up()
    {
         $this->dropColumn('posts', 'description');
         $this->renameColumn('posts', 'text', 'content');
    }

    public function down()
    {
         $this->addColumn('posts', 'description', $this->text());
         $this->renameColumn('posts', 'content', 'text');
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
