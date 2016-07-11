<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Edit Profile';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($model->activeNew);
//die();
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">
            <p>
                 Current picture:
            </p>
            <?= Html::img(Url::toRoute($model->profilePicture), ['width' => '150px']) ?><br/><br/>
            <p>
                 Select and upload your new profile picture:
            </p>
            <?php $form = ActiveForm::begin([
                 'options' => ['enctype' => 'multipart/form-data'],
                 'action' => ['profile/picture'],
            ]) ?>

            <?= $form->field($model, 'picture')->widget(FileInput::classname(), [
                  'options' => ['multiple' => false, 'accept' => 'image/*'],
                  'pluginOptions' => [
                       'previewFileType' => 'image',
                       'showUpload' => true,
                  ],
            ])?>

            <?php ActiveForm::end(); ?>

            <br/><hr/><br/>

            <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>
                 <?php
                    if($model->active == 1){
                         echo 'If you will uncheck following checkbox and press \'EDIT PROFILE\' button, your account became not active. That\'s mean, that other people can\'t find you by using search:';
                    }
                    else{
                         echo 'If you will press following checkbox and press \'EDIT PROFILE\' button, your account became active. That\'s mean, that other people can find you by using search:';
                    }
                 ?>
                 <?= $form->field($model, 'active')->checkbox(); ?>

                 <?= $form->field($model, 'username')->textInput([/*'autofocus' => true, */'value' => $model->username]) ?>

                 <?= $form->field($model, 'newPassword')->passwordInput() ?>

                 <?= $form->field($model, 'editPassword')->checkbox() ?>

                 <div class="form-group">
                        <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                 </div>

            <?php ActiveForm::end(); ?>


       </div>
    </div>

</div>
