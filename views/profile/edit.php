<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Profile';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'edit-form',
             ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => $model->username]) ?>

                <?= $form->field($model, 'newPassword')->passwordInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'editPassword')->checkbox() ?>

                <div class="form-group">
                        <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
