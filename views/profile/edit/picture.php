<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Tabs;

?>
<br/><hr/>
<p>
     Current picture:
</p>
<?= Html::img(Url::toRoute($model->user->profilePicture), ['width' => '150px']) ?><br/><br/>
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

<br/><hr/>
