<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = $this->title;

?>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<div class="site-about">


    <div class="row">
         <div class='postCreate'>
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>

                <?= $form->field($model, 'userId')->hiddenInput(['autofocus' => true, 'value' => Yii::$app->user->getId()])->label(false) ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'content')->textArea(['rows' => 10]); ?>


                <?= $form->field($model, 'dateCreate')->hiddenInput(['autofocus' => true, 'value' => $date])->label(false) ?>

                <?= $form->field($model, 'dateUpdate')->hiddenInput(['autofocus' => true, 'value' => $date])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'posts-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
