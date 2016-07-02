<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
         <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?=
          ListView::widget([
               'dataProvider' => $dataProvider,
               'itemView' => 'listview/post',
          ]);
    ?>

</div>
