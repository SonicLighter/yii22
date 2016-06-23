<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This webpage is abailable for admins only!<br/>
        Users list:
    </p>

    <?=//
         GridView::widget([
              'dataProvider' => $dataProvider,
              'columns' => [
                  'username',
                  'admin',
              ],
          ]);
     ?>



</div>
