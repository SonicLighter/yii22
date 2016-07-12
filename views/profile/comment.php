<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


       <div class='searchWrapper'>
              <h4><?php echo $modelPosts->title; ?></h4>
              <hr/>
              <h4>Entire post:</h4>
              <?php echo $modelPosts->content; ?>
              <hr/>
       </div>
       <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'comments-form']); ?>

                <?= $form->field($model, 'message')->textarea(['autofocus' => true, 'rows' => 5]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'posts-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

       </div>


</div>
