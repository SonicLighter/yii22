<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class AdminModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function beforeControllerAction($controller, $action){

         if(parent::beforeControllerAction($controller, $action)){
              
              return true;
         }
         else{
              return false;
         }

    }

}
