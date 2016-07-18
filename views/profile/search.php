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

$this->title = 'People';
?>
<div class="site-about">
     <div class='searchPage'>
         <p>
              <?= Html::a('Reset search', [Url::toRoute([$pageType])], ['class' => 'btn btn-info']) ?>
              <?= Html::a('Profile', [Url::toRoute(['profile/index', 'id' => Yii::$app->user->id])], ['class' => 'btn btn-info']) ?>
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
                          'triggerText' => 'Load more messages...',
                          'noneLeftText' => 'End of page',
                          'triggerOffset' => $loadPage,
                          'noneLeftTemplate' => '<div class="ias-noneleft" style="text-align: center;"><div class="userMenu">{text}</div></div>',
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
                                 $acceptButton = "";
                                 $infoMessage = "";
                                 if(empty($model->friend)){
                                      $resultButton = Html::a('Add to friends', [Url::toRoute(['invite', 'id' => $model->id])], ['class' => 'btn btn-info']);
                                 }
                                 else{
                                      if(!empty($model->sender) && ($model->sender->accepted == 0)){
                                           $infoMessage = "Info: This user did not accept you yet.";
                                      }
                                      else if(!empty($model->receiver) && ($model->receiver->accepted == 0)){
                                           $infoMessage = "Info: You didn't accept this user.";
                                           $acceptButton = Html::a('Accept user&nbsp', [Url::toRoute(['accept', 'id' => $model->id])], ['class' => 'btn btn-info']);
                                      }
                                      $resultButton = Html::a('Delete friend', [Url::toRoute(['remove', 'id' => $model->id])], ['class' => 'btn btn-info']);
                                 }
                                 $resultString =
                                     "<div class='searchWrapper'>
                                           <div class='searchLeftColumn'>
                                                ".Html::img(Url::toRoute($model->profilePicture), ['width' => '120px'])."
                                           </div>
                                           <div class='searchMiddleColumn'>
                                                <h4>Username: ". Html::a(HtmlPurifier::process($model->username), [Url::toRoute(['index', 'id' => $model->id])])."</h4>

                                                E-mail: ".HtmlPurifier::process($model->email)."<br/>

                                                Role: ".HtmlPurifier::process($model->role->item_name)."<br/>

                                                ".$infoMessage."

                                           </div>
                                           <div class='searchRightColumn'>
                                                ".$acceptButton."<br/><br/>".$resultButton."
                                           </div>
                                      </div>";
                                  return $resultString;
                            },
                       ],
                   ],
              ]);
          ?>
     </div>
</div>
