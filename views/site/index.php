<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'SOCIALNETWORK.COM';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to SOCIALNETWORK.COM!</h1>

        <p class="lead">We are suggest you to <?= HTML::a('login', Url::toRoute(['site/login']))?> or register:</p>

        <div class='registerPage'>
             <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>

                 <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                 <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                 <?= $form->field($model, 'password')->passwordInput() ?>

                 <div class="form-group">
                     <?= Html::submitButton('Registration', ['class' => 'btn btn-primary', 'name' => 'user-button']) ?>
                 </div>

             <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
