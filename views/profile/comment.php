<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\widgets\ListView;

$this->title = 'Comments';

?>
<div class="site-about">

      <div class='postCreate'>
           <p>
                <?= Html::a($modelPosts->user->username, Url::toRoute(['profile/index', 'id' => $modelPosts->userId]), ['class' => 'btn btn-profile-menu']) ?>
           </p>
           <br/><p><h3>Post:</h3></p>
            <div class='searchWrapper'>
                   <h4><?php echo $modelPosts->title; ?></h4>
                   <hr/>
                   <h4>Entire post:</h4>
                   <?php echo $modelPosts->content; ?>
                   <hr/>
            </div>

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
                          echo '<br/><hr/><h4>'.$modelPosts->user->username.' changed some settings, which is not allow you to leave a comment here.</h4><hr/>';
                     }
                ?>

                     <div class="form-group">
                         <?php
                              if($changePermission || (Yii::$app->user->id == $modelPosts->userId)){
                                   echo Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'posts-button']);
                              }
                         ?>
                     </div>

                 <?php ActiveForm::end(); ?>
                 <div class='commentsWrapper'>
                           <br/><p><h3>Comments:</h3></p>
                           <?=
                                ListView::widget([
                                     'dataProvider' => $modelPosts->postComments,
                                     'summary' => false,
                                     //'itemOptions' => ['class' => 'item'],
                                     'itemView' => 'lists/comments',
                                     //'pager' => ['class' => ScrollPager::className()],
                                ])
                           ?>
                 </div>
     </div>

</div>
