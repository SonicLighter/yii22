<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;

$this->title = 'Create Post';

?>

<!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>-->

<div class="site-about">


    <div class="row">
         <div class='postCreate'>
            <h4><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>

                <?= $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

                <?= $form->field($model, 'title')->textInput() ?>

                <?= $form->field($model, 'content')->widget(TinyMce::className(), [
                   'options' => ['rows' => 10],
                   'language' => 'en_GB',
                   'clientOptions' => [
                       'plugins' => [
                           "advlist autolink lists link charmap print preview anchor",
                           "searchreplace visualblocks code fullscreen",
                           "insertdatetime media table contextmenu paste"
                       ],
                       'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                  ],
                ]);?>


                <?= $form->field($model, 'dateCreate')->hiddenInput(['value' => $date])->label(false) ?>

                <?= $form->field($model, 'dateUpdate')->hiddenInput(['value' => $date])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'posts-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
