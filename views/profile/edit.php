<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Tabs;

$this->title = 'Edit Profile';
//var_dump($model->activeNew);
//die();
?>
<div class="site-about">


    <div class="row">
       <div class='postCreate'>
             <h1><?= Html::encode($this->title) ?></h1><br/>
             <?php
                    $pictureActive = true;
                    $accessActive = true;
                    if($model->scenario == "editProfile"){
                         $pictureActive = false;
                    }
                    else{
                         $accessActive = false;
                    }
             ?>
            <?=
                 Tabs::widget([
                     'items' => [
                         [
                             'label' => 'Public',
                             'content' => Yii::$app->controller->renderPartial('edit/picture', [
                                  'model' => $model,
                             ]),
                             'active' => $pictureActive,
                         ],
                         [
                             'label' => 'Access',
                             'content' => Yii::$app->controller->renderPartial('edit/access', [
                                  'model' => $model,
                             ]),
                             'active' => $accessActive,
                         ],
                         [
                             'label' => 'Example',
                             'url' => 'http://www.example.com',
                         ],
                     ],
                 ])
            ?>
       </div>
    </div>

</div>
