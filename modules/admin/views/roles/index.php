<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-default']) ?><br/><br/>
    <?=

         GridView::widget([
              'dataProvider' => $dataProvider,
              'summary' => false,
              'columns' => [
                  [
                       'header' => 'Roles:',
                       'value' => 'item_name',
                  ],
                  [
                       'header' => 'Options',
                       'class' => ActionColumn::className(),
                       'template' => '{delete}',
                       'visible' => Yii::$app->user->can("openRoles"),
                       'options' => ['style' => 'width: 65px; max-width: 65px;'],
                  ],
              ],
          ]);

     ?>

</div>
