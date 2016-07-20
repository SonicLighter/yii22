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
          <div class='editInfoBlock'>
               <?= $form->field($model, 'dob')->widget(
                   DatePicker::className(), [
                       'inline' => false,
                       'clientOptions' => [
                           'autoclose' => true,
                           'format' => 'dd-mm-yyyy'
                      ],
               ]);?>
          </div>
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

          <div class='editInfoBlock'>
               <?= $form->field($model, 'address')->textInput(['value' => $model->address]) ?>
          </div>

          <div class="form-group">
                 <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'info-button']) ?>
          </div>

     <?php ActiveForm::end(); ?>

<br/><hr/>
