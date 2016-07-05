<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Profile';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-profile">
      <div class='profile-left_column'>
           <?= Html::img(Url::toRoute(Yii::$app->user->identity->profilePicture), ['width' => '100%']) ?>
           <br/><br/>
           <a href='edit'><div class='userMenu'>Edit Profile</div></a>
           <a href='picture'><div class='userMenu'>Set Profile Picture</div></a>
      </div>
      <div class='profile-right_column'>
           <div class='profile-right_column-header'>

                     Profile (Username: <?php echo Yii::$app->user->identity->username ?> /
                     E-mail: <?php echo Yii::$app->user->identity->email ?>)

           </div>
           <div class='profile-right_column-content'>

           </div>
      </div>
</div>
