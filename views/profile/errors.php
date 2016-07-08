<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Error';
//var_dump($model->activeNew);
//die();
?>
<div class="site-about">

    <div class="row">
         <h1><?= Html::encode($this->title) ?></h1>
         <h1>Why do you see this page? The answer is:</h1>
         <p>
              1. User, which you are going to (add,delete,accept) (to,from) friends not exists already.
         </p>
         <p>
              2. User, which you are going to (delete,accept) (to,from) friends delete you from friends already.
         </p>
    </div>

</div>
