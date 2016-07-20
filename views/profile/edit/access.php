<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Tabs;
use kartik\checkbox\CheckboxX;

?>
<br/><hr/>

     <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>

          <?= $form->field($model, 'commentPermission')->widget(CheckboxX::classname(), [
              'autoLabel'=>true,
          ])->label(false) ?>

          <?php
             /*
             if($model->active == 1){
                  echo 'If you will uncheck following checkbox and press \'EDIT PROFILE\' button, your account became not active. That\'s mean, that other people can\'t find you by using search:';
             }
             else{
                  echo 'If you will press following checkbox and press \'EDIT PROFILE\' button, your account became active. That\'s mean, that other people can find you by using search:';
             }
             */
          ?>
          <?= $form->field($model, 'active')->widget(CheckboxX::classname(), [
              'autoLabel'=>true,
          ])->label(false) ?>

          <?= $form->field($model, 'username')->textInput([/*'autofocus' => true, */'value' => $model->username]) ?>

          <?= $form->field($model, 'newPassword')->passwordInput() ?>

          <?= $form->field($model, 'editPassword')->widget(CheckboxX::classname(), [
              'autoLabel'=>true,
          ])->label(false) ?>

          <div class="form-group">
                 <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div>

     <?php ActiveForm::end(); ?>

<br/><hr/>
