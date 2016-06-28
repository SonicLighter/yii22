<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This webpage is available for admins and moderators only!<br/>
    </p>
    <?php
          if(key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())) == 'admin'){
               printf("
                    <p>
                         Follow this link to create a new user: <a href='create'> Create User </a> <br/>
                    </p>
               ");
          }
    ?>

    <p>
        Users list:
    </p>

    <?=
         GridView::widget([
              'dataProvider' => $dataProvider,
              'columns' => [
                  [
                       'header' => 'Name',
                       'value' => 'username',
                  ],
                  [
                       'header' => 'Role',
                       'value' => function($model){
                            return key(Yii::$app->authManager->getRolesByUser($model->id));
                       },
                  ],
                  [
                       'header' => 'Options',
                       'class' => ActionColumn::className(),
                       'template' => '{update} {delete}',
                       'visible' => (Yii::$app->user->can("openRoles")) ? (true) : (false),
                       'options' => ['style' => 'width: 65px; max-width: 65px;'],
                  ],
              ],
          ]);
     ?>

</div>
