<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\widgets\ListView;
use \kop\y2sp\ScrollPager;
use yii\helpers\HtmlPurifier;

$this->title = 'Comments';

?>
<div class="site-about">
     <div class='post-comments-wrapper'>
     <?php
          $buttonUpdate = "";
          $buttonDelete = "";
          $comments = Html::a('<i class="glyphicon glyphicon-comment"></i> '.$modelPosts->commentsCount.'', [Url::toRoute(['comment', 'id' => $modelPosts->id])]);
          $date = $modelPosts->dateUpdate;
          if($modelPosts->dateCreate != $modelPosts->dateUpdate){
               $date = '<i class="glyphicon glyphicon-pencil"></i> &nbsp '.$modelPosts->dateUpdate;
          }
          if($modelPosts->userId == Yii::$app->user->id){
               $buttonUpdate = Html::a('<i class="glyphicon glyphicon-edit"></i>', [Url::toRoute(['posts/update', 'id' => $modelPosts->id])]);
               $buttonDelete = Html::a('<i class="glyphicon glyphicon-trash"></i>', [Url::toRoute(['posts/delete', 'id' => $modelPosts->id])]);
          }
     ?>

     <div class='profile-right_item-news'>
          <?= Html::a("<i class='glyphicon glyphicon-arrow-left'></i> back to ".$modelPosts->user->username, Url::toRoute(['profile/index', 'id' => $modelPosts->userId])); ?>
          <hr/>
          <div class='profile-right_item-newstitle'>
               <?php echo $modelPosts->title; ?>
          </div>
          <div class='profile-right_item-active'>
               <?php echo $buttonUpdate.$buttonDelete ?>
          </div><br/><hr/>
          <?php echo $modelPosts->content; ?>
          <hr/>
          <div class='profile-right_item-newsdate'>
               <?php echo $date; ?>
          </div>
          <div class='profile-right_item-newscomments'>
               <?php echo $comments; ?>
          </div><br/>
     </div>
     <div class='profile-right_item-news'>
            <?php $form = ActiveForm::begin(['id' => 'comments-form']); ?>

            <?php
                 $changePermission = ($modelPosts->user->profile->commentPermission == 1);
                 if($changePermission || (Yii::$app->user->id == $modelPosts->userId)){
                      echo $form->field($model, 'message')->widget(TinyMce::className(), [
                        'options' => ['rows' => 5],
                        'language' => 'en_GB',
                        'clientOptions' => [
                            'plugins' => [
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste"
                            ],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                       ],
                     ]);
                }
                else{
                     echo '<h4>'.$modelPosts->user->username.' changed some settings, which is not allow you to leave a comment here.</h4>';
                }
           ?>

          <?php
               if($changePermission || (Yii::$app->user->id == $modelPosts->userId)){
                    echo Html::submitButton('Submit', ['class' => 'btn btn-default', 'name' => 'posts-button']);
               }
          ?>

            <?php ActiveForm::end(); ?>
     </div>

       <!--<?=
            ListView::widget([
                 'dataProvider' => $modelPosts->postComments,
                 'summary' => false,
                 //'itemOptions' => ['class' => 'item'],
                 'itemView' => 'lists/comments',
                 //'pager' => ['class' => ScrollPager::className()],
            ])
       ?>-->
       <?=
            GridView::widget([
                 'dataProvider' => $modelPosts->postComments,
                 'summary' => false,
                 'emptyText' => '',
                 //'layout' => "{pager}\n{items}\n{pager}",
                 'tableOptions' => [
                    'class' => 'myGridView', /*table table-striped table-bordered*/
                 ],
                 'pager' => [
                       'class' => ScrollPager::className(),
                       'container' => '.grid-view tbody',
                       'item' => 'tr',
                       'paginationSelector' => '.grid-view .pagination',
                       'triggerText' => 'Load more posts...',
                       'noneLeftText' => 'End of page',
                       'triggerOffset' => $loadCount,
                       'noneLeftTemplate' => '',
                       'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer"><div class="btn btn-content">{text}</div></a></td></tr>',
                 ],
                 'columns' => [
                    [
                         'format' => 'html',
                         //'header' => 'Name',
                         'value' => function($model){
                              $resultString = "
                                   <div class='profile-right_item-news'>
                                        <div class='commentLeftColumn'>
                                             ".Html::img(Url::toRoute($model->user->profilePicture), ['width' => '120px'])."
                                        </div>
                                        <div class='commentMiddleColumn'>
                                             ".Html::a(HtmlPurifier::process($model->user->username), [Url::toRoute(['index', 'id' => $model->user->id])])."<hr/>
                                             ".$model->message."
                                        </div>
                                        <div class='commentRightColumn'>
                                             ".((Yii::$app->user->id == $model->user->id)?(Html::a('Delete', [Url::toRoute(['deletecomment', 'id' => $model->id])], ['class' => 'btn btn-default'])):(''))."
                                        </div>
                                   </div>
                              ";
                              return $resultString;
                         },
                    ],
                 ],
            ]);
       ?>
     </div>
</div>
