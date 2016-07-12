<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Update Post';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'posts-form']); ?>

                <?= $form->field($model, 'userId')->hiddenInput(['autofocus' => true, 'value' => $model->userId])->label(false) ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'value' => $model->title]) ?>

                <?= $form->field($model, 'content')->textarea(['autofocus' => true, 'rows' => 8, 'value' => $model->content]) ?>

                <?= $form->field($model, 'dateCreate')->hiddenInput(['autofocus' => true, 'value' => $model->dateCreate])->label(false) ?>

                <?= $form->field($model, 'dateUpdate')->hiddenInput(['autofocus' => true, 'value' => $date])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'posts-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
