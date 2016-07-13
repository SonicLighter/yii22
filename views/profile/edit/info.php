<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Tabs;
use dosamigos\datepicker\DatePicker;

?>
<br/><hr/><br/>

     <?php $form = ActiveForm::begin([
          'id' => 'posts-form',
          'action' => ['profile/info'],
     ]); ?>

          <?= $form->field($model, 'dob')->widget(
              DatePicker::className(), [
                  'inline' => true,
                  'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                  'clientOptions' => [
                      'autoclose' => true,
                      'format' => 'dd-M-yyyy'
                  ]
          ]);?>

          <div class="form-group">
                 <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'info-button']) ?>
          </div>

     <?php ActiveForm::end(); ?>

<br/><hr/>
