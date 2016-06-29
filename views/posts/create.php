<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>

                <?= $form->field($model, 'userId')->hiddenInput(['autofocus' => true, 'value' => Yii::$app->user->getId()])->label(false) ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['autofocus' => true, 'rows' => 5]) ?>

                <?= $form->field($model, 'text')->textarea(['autofocus' => true, 'rows' => 8]) ?>

                <?= $form->field($model, 'dateCreate')->hiddenInput(['autofocus' => true, 'value' => $date])->label(false) ?>

                <?= $form->field($model, 'dateUpdate')->hiddenInput(['autofocus' => true, 'value' => $date])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'posts-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
