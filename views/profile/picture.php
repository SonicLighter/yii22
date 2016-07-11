<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Profile Picture';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">
            <p>
                 Select and upload your new profile picture:
            </p>
            <?php


            ?>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <!--<?= $form->field($model, 'picture')->fileInput() ?>-->
                <?= $form->field($model, 'picture')->widget(FileInput::classname(), [
                       'options' => ['multiple' => false, 'accept' => 'image/*'],
                       'pluginOptions' => [
                           'previewFileType' => 'image',
                           'showUpload' => true
                       ],
                ])?>
                <div class="form-group"><br/>
                        <?= Html::submitButton('Upload Picture', ['class' => 'btn btn-primary', 'name' => 'upload-picture-button']) ?>
                </div>

            <?php ActiveForm::end() ?>

       </div>
    </div>

</div>
