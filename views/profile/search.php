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

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
         <?= Html::a('Reset search', [Url::toRoute(['search'])], ['class' => 'btn btn-info']) ?>
    </p>
    <!--<?=
          ListView::widget([
               'dataProvider' => $dataProvider,
               'summary' => false,
               'itemView' => 'search/user',
          ]);
    ?>-->
    <?=
         GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
              'summary' => false,
              'columns' => [
                  [
                       'class' => DataColumn::className(), // this line is optional
                       'attribute' => 'username',
                       'label' => 'Search by username',
                       'format' => 'html',
                       //'header' => 'Name',
                       'value' => function($model){
                            $resultString =
                                "<div class='searchWrapper'>
                                      <div class='searchLeftColumn'>
                                           ".Html::img(Url::toRoute($model->profilePicture), ['width' => '120px'])."
                                      </div>
                                      <div class='searchMiddleColumn'>
                                           <h4>Username: ".HtmlPurifier::process($model->username)."</h4>

                                           E-mail: ".HtmlPurifier::process($model->email)."<br/>

                                           Role: ".HtmlPurifier::process($model->role->item_name)."

                                      </div>
                                      <div class='searchRightColumn'>
                                           ".Html::a('Add to friends', [Url::toRoute(['invite', 'id' => $model->id])], ['class' => 'btn btn-info'])."
                                      </div>
                                 </div>";
                                 return $resultString;
                       },
                  ],
              ],
         ]);
     ?>

</div>
