<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Role';

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>

                <?= $form->field($model, 'item_name')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-default', 'name' => 'user-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
