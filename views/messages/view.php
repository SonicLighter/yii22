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
use yii\widgets\Pjax;

$this->title = 'Dialog with '.$modelUser->username;
?>

<div class="site-about">
     <div class='postCreate'>
          <h4><?= Html::a('Dialog', Url::toRoute(['messages/view', 'id' => $modelUser->id])).' with '.Html::a($modelUser->username, Url::toRoute(['profile/index', 'id' => $modelUser->id])) ?></h4>

          <div class='sendForm'>

               <?php $form = ActiveForm::begin([
                    'id' => 'messages-form',
                    'action' => ['messages/add', 'id' => $modelUser->id],
                    'method' => 'post',
               ]); ?>
               <div class='sendMessage'>
                    <?= $form->field($model, 'message')->textInput(['autofocus' => true]) ?>
               </div>
                    <?= Html::submitButton('Send', ['class' => 'btn btn-send', 'name' => 'posts-button']) ?>

               <?php ActiveForm::end(); ?>

               <hr/>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        //'layout' => "{pager}\n{items}\n{pager}",
                        'tableOptions' => [
                             'class' => 'myGridView', /*table table-striped table-bordered*/
                        ],

                        'pager' => [
                               'class' => ScrollPager::className(),
                               'container' => '.grid-view tbody',
                               'item' => 'tr',
                               'paginationSelector' => '.grid-view .pagination',
                               'triggerText' => 'Load more messages...',
                               'noneLeftText' => '',
                               'triggerOffset' => $loadPage,
                               'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer"><div class="btn btn-content">{text}</div></a></td></tr>',
                        ],

                        'columns' => [
                             [
                                  'format' => 'html',
                                  'value' => function($model){
                                       if($model->senderId == Yii::$app->user->id){$wrapper = 'myMessageWrapper';}
                                       else{$wrapper = 'otherMessageWrapper';}
                                       $profilePicture = Html::img(Url::toRoute($model->sender->profilePicture), ['width' => '30px']);
                                       $resultString = "
                                             <div class='".$wrapper."'>
                                                  <div class='messageImage'>
                                                       ".$profilePicture."
                                                  </div>
                                                  <div class='messageContent'>
                                                       ".Html::a($model->sender->username, Url::toRoute(['profile/index', 'id' => $model->sender->id]))."
                                                       | ".$model->date."<br/>
                                                       ".$model->message."
                                                  </div>
                                                  <hr/>
                                             </div>
                                       ";

                                       return $resultString;
                                  },
                             ],
                        ],
                    ]);?>
          </div>
     </div>
</div>
