<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
          ListView::widget([
               'dataProvider' => $dataProvider,
               'itemView' => 'search/user',
          ]);
    ?>

</div>
