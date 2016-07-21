<?php

namespace app\modules\admin;

use Yii;

/**
 * admin module definition class
 */
class AdminModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function beforeAction($action){

        if (!parent::beforeAction($action)) {
             return false;
        }

        if (Yii::$app->user->can('admin') || Yii::$app->user->can('moderator')){
             return true;
        }
        else if(($action->controller->id == 'default') && ($action->controller->action->id == 'index')){
             return true;
        }
        else {
             Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
             return false;
        }

    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

}
