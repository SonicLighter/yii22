<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;

$this->title = 'AdminPanel';

?>
<div class="site-about">
     <div class="alert alert-success">Welcome to adminpanel, <?= Html::encode(Yii::$app->user->identity->username) ?>!</div>
     <center> <?= Html::img(Url::toRoute('../images/default/admin.jpg'), ['width' => '600px']) ?> </center>
</div>
