<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-profile">
      <div class='profile-left_column'>
           Hello
      </div>
      <div class='profile-right_column'>
           <div class='profile-right_column-header'>
                <h4> Profile (Username: <?php echo Yii::$app->user->identity->username ?> /
                E-mail: <?php echo Yii::$app->user->identity->email ?>) </h4>
           </div>
           <div class='profile-right_column-content'>
                
           </div>
      </div>
</div>
