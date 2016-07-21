<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
use yii\captcha\Captcha;

$this->title = 'Admin Panel';
?>

<div class='admin-login-wrapper'>
     <center><h1><?= Html::encode($this->title) ?></h1></center>
     <div class='admin-login-input-wrapper'>
          <?php $form = ActiveForm::begin([
             'id' => 'login-form',
             'options' => ['class' => 'form-horizontal'],
         ]); ?>

             <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

             <?= $form->field($model, 'password')->passwordInput() ?>

             <?= $form->field($model, 'rememberMe')->widget(CheckboxX::classname(), [
                 'autoLabel'=>true,
                 'pluginOptions'=>['threeState'=>false],
             ])->label(false) ?>


             <?= Html::submitButton('Login', ['class' => 'btn btn-login', 'name' => 'login-button']) ?>

         <?php ActiveForm::end(); ?>
    </div>
</div>
