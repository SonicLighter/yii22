<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$this->title = 'New Friends';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
     <h1><?= Html::encode($this->title) ?></h1>
</div>
