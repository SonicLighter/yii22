<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use \kop\y2sp\ScrollPager;

$this->title = 'Dialog with '.$modelUser->username;
?>

<div class="site-about">
     <div class='searchPage'>
          <h1><?= Html::encode($this->title) ?></h1>

          <div class='sendForm'>

               <?php $form = ActiveForm::begin([
                    'id' => 'messages-form',
                    'action' => ['messages/add', 'id' => 1],
                    'method' => 'post',
               ]); ?>
               <div class='sendMessage'>
                    <?= $form->field($model, 'message')->textArea(['autofocus' => true], ['rows' => 3]) ?>
               </div>
                    <?= Html::submitButton('Send', ['class' => 'sendButton', 'name' => 'posts-button']) ?>

               <?php ActiveForm::end(); ?>
          </div>
     </div>
</div>
