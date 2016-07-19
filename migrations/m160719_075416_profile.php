<?php

use yii\db\Migration;
use app\models\User;
use app\models\Profile;

class m160719_075416_profile extends Migration
{
    public function up()
    {

         $this->createTable('profile',[
              'id' => $this->primaryKey(),
              'userId' => $this->integer()->notNull(),
              'active' => $this->boolean()->notNull(),
              'birthday' => $this->string(),
              'phone' => $this->string(),
              'address' => $this->string(),
              'commentPermission' => $this->boolean()->notNull(),
         ]);

         $this->addForeignKey('fk_profile_users', 'profile', 'userId', 'users', 'id');

         $users = User::find()->all();
         foreach ($users as $user) {
              $this->insert('profile',['userId' => $user->id, 'active' => $user->active, 'birthday' => $user->birthday,
                                        'phone' => $user->phone, 'address' => $user->address, 'commentPermission' => $user->commentPermission]);
         }

         $this->dropColumn('users', 'active');
         $this->dropColumn('users', 'birthday');
         $this->dropColumn('users', 'phone');
         $this->dropColumn('users', 'address');
         $this->dropColumn('users', 'commentPermission');

    }

    public function down()
    {
         /*
         $this->addColumn('users', 'active', $this->boolean());
         $this->addColumn('users', 'birthday', $this->string());
         $this->addColumn('users', 'phone', $this->string());
         $this->addColumn('users', 'address', $this->string());
         $this->addColumn('users', 'commentPermission', $this->boolean());

         $profiles = Profile::find()->all();
         foreach ($profiles as $profile) {

              $user = User::findIdentity($profile->userId);
              $user->active = $profile->active;
              $user->birthday = $profile->birthday;
              $user->phone = $profile->phone;
              $user->address = $profile->address;
              $user->commentPermission = $profile->commentPermission;
              $user->save();

              $this->update('users',['active' => $profile->active, 'birthday' => $profile->birthday, 'phone' => $profile->phone,
                              'address' => $profile->address, 'commentPermission' => $profile->commentPermission], ['id' => $profile->userId]);
         }

         $this->dropForeignKey('fk_profile_users', 'profile');
         $this->dropTable('profile');
         */

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
