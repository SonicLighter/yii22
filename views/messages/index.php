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
use \kop\y2sp\ScrollPager;

$this->title = 'Dialogs';

?>
<div class="site-about">
     <div class='postCreate'>
          <h1><?= Html::encode($this->title) ?></h1>
          <p>
               <?= Html::a('Reset search', 'index', ['class' => 'btn btn-default']) ?>
               <?= Html::a('Profile', [Url::toRoute(['profile/index', 'id' => Yii::$app->user->id])], ['class' => 'btn btn-default']) ?>
          </p>

          <?=
              GridView::widget([
                   'dataProvider' => $dataProvider,
                   'filterModel' => $searchModel,
                   'summary' => false,
                   'pager' => [
                         'class' => ScrollPager::className(),
                         'container' => '.grid-view tbody',
                         'item' => 'tr',
                         'paginationSelector' => '.grid-view .pagination',
                         'triggerText' => 'Load more dialogs...',
                         'noneLeftText' => '',
                         'triggerOffset' => $loadPage,
                         'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer"><div class="userMenu">{text}</div></a></td></tr>',
                   ],
                   'columns' => [
                       [
                            'class' => DataColumn::className(),
                            'attribute' => 'username',
                            'label' => 'Search by username',
                            'format' => 'html',
                            //'header' => 'Name',
                            'value' => function($model){
                                 $resultString =
                                     "
                                           <div class='dialogLeftColumn'>
                                                ".Html::img(Url::toRoute($model->profilePicture), ['width' => '120px'])."
                                           </div>
                                           <div class='dialogMiddleColumn'>
                                                <h4>Open dialog with ". Html::a(HtmlPurifier::process($model->username), [Url::toRoute(['view', 'id' => $model->id])])."</h4>
                                           </div>
                                      ";
                                  return $resultString;
                            },
                       ],
                       [
                           'attribute' => 'newMessages',
                           'label' => 'New',
                           'format' => 'html',
                           'value' => function($model){
                                $resultString =
                                     "<div class='newMessagesWrapper'>
                                             ".$model->newMessages."
                                     </div>
                                ";
                                return $resultString;
                           },
                           'filter' => false,
                      ],
                   ],
              ]);
          ?>

     </div>
</div>
