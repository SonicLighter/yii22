<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Update User';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This webpage is available for admins only!<br/>
    </p>
    <div class="row">
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'update-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => $user->username]) ?>

                <?= $form->field($model, 'password')->hiddenInput(['autofocus' => true, 'value' => $user->password])->label(false) ?>

                <?= $form->field($model, 'authKey')->textInput(['autofocus' => true, 'value' => $user->authKey]) ?>

                <?= $form->field($model, 'accessToken')->textInput(['autofocus' => true, 'value' => $user->accessToken]) ?>

                <?= $form->field($model, 'role')->dropDownList($roles,[
                         'prompt' => 'Choose role...',

                     ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>
    </div>

</div>
