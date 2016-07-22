<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\checkbox\CheckboxX;

$this->title = 'Login';
?>
<div class="site-login">

     <div class='registerPage'>
         <h4><?= Html::encode($this->title) ?></h1>
         <p>Please fill out the following fields to login:</p>

         You may login with <strong>admin@yii.by/admin</strong>.<br/><br/>

         <?php $form = ActiveForm::begin([
             'id' => 'login-form',
         ]); ?>

             <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

             <?= $form->field($model, 'password')->passwordInput() ?>



             <?= $form->field($model, 'rememberMe')->widget(CheckboxX::classname(), [
                 'autoLabel'=>true,
                 'pluginOptions'=>['threeState'=>false],
             ])->label(false) ?>


             <center> <?= Html::submitButton('Login', ['class' => 'btn btn-default', 'name' => 'login-button']) ?> </center>


         <?php ActiveForm::end(); ?>
    </div>
</div>
