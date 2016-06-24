<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

     public function actionInit(){

          $auth = YII::$app->authManager;

          // Permissins...
          $openUsers = $auth->createPermission('openUsers');
          $openUsers->description = "Open users page";
          $auth->add($openUsers);

          $openRoles = $auth->createPermission('openRoles');
          $openRoles->description = "Open roles page";
          $auth->add($openRoles);

          // Roles...
          $admin = $auth->createRole('admin');
          $auth->add($admin);
          $auth->addChild($admin, $openUsers);
          $auth->addChild($admin, $openRoles);

          $moderator = $auth->createRole('moderator');
          $auth->add($moderator);
          $auth->addChild($moderator, $openUsers);

          $user = $auth->createRole('user');
          $auth->add($user);

          // Assign roles to users
          $auth->assign($admin, 1);
          $auth->assign($moderator, 3);
          $auth->assign($user, 2);

     }

}
?>
