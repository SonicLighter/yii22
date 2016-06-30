<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\User;

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
          //echo "<br/>".$dataProvider->models[]->id;
          //die();
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
                       'header' => 'News count',
                       'value' => 'postCount',
                  ],
                  [
                       'header' => 'Options',
                       'class' => ActionColumn::className(),
                       'template' => '{update} {delete}',
                       'buttons' => [
                            'update' => function($url, $model){
                                 return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                  [
                                      'title' => Yii::t('app', 'Update user'),
                                  ]);
                            },
                            'delete' => function($url, $model){
                                 if($model->id !=Yii::$app->user->getId()){
                                      return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                       [
                                           'title' => Yii::t('app', 'Delete user'),
                                       ]);
                                 }
                            },
                       ],
                       'visible' => Yii::$app->user->can("openRoles"),
                       'options' => ['style' => 'width: 65px; max-width: 65px;'],
                  ],
              ],
          ]);
     ?>

</div>
