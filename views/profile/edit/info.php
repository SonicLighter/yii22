<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Tabs;
use dosamigos\datepicker\DatePicker;
use borales\extensions\phoneInput\PhoneInput;

?>
<br/><hr/>

     <?php $form = ActiveForm::begin([
          'id' => 'posts-form',
          'action' => ['profile/info'],
     ]); ?>

          <?= $form->field($model, 'dob')->widget(
              DatePicker::className(), [
                  'inline' => false,
                  'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                  'clientOptions' => [
                      'autoclose' => true,
                      'format' => 'dd-M-yyyy'
                 ],
          ]);?>

          <p>
               Type code to your country, example (for Belarus): +375 29 000-00-00
          </p>
          <?=
               $form->field($model, 'phone')->widget(PhoneInput::className(), [
                   'jsOptions' => [
                       //'preferredCountries' => ['by', 'ru', 'ua'],
                       'onlyCountries' => ['by', 'ru', 'ua'],
                   ]
               ])
          ?>

          <?= $form->field($model, 'address')->textInput(['value' => $model->address]) ?>

          <div class="form-group">
                 <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'info-button']) ?>
          </div>

     <?php ActiveForm::end(); ?>

<br/><hr/>
