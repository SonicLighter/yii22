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
         <h4> Filters: </h4>
    </p>
    <p>
         <h4> Users list: </h4>
    </p>

    <?=
         GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
          ]);
     ?>

</div>
