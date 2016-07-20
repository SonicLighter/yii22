<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\DataColumn;
use yii\widgets\ListView;
use \kop\y2sp\ScrollPager;

$this->title = $model->username;
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-profile">
      <div class='profile-left_column'>
           <?= Html::img(Url::toRoute($model->profilePicture), ['width' => '100%']) ?>
           <br/><br/>
           <?php
               if($model->id == Yii::$app->user->id){
                    echo Html::a("Edit Profile", [Url::toRoute(['edit'])], ['class' => 'btn btn-profile-menu']);
                    echo Html::a("New Friends (".$waitingCount.")", [Url::toRoute(['waiting'])], ['class' => 'btn btn-profile-menu']);
                    echo Html::a("My Requests (".$notAcceptedCount.")", [Url::toRoute(['requests'])], ['class' => 'btn btn-profile-menu']);
               }
               else{
                    echo Html::a("Send message", [Url::toRoute(['messages/view', 'id' => $model->id])] , ['class' => 'btn btn-profile-menu']);
                    if(empty($model->friend)){
                         echo Html::a("Add to friends", [Url::toRoute(['invite', 'id' => $model->id])], ['class' => 'btn btn-profile-menu']);
                    }
                    else{
                         if(!empty($model->receiver) && ($model->receiver->accepted == 0)){
                              echo Html::a("Accept user&nbsp", [Url::toRoute(['accept', 'id' => $model->id])], ['class' => 'btn btn-profile-menu']);
                         }
                         echo Html::a("Delete friend", [Url::toRoute(['remove', 'id' => $model->id])], ['class' => 'btn btn-profile-menu']);
                    }
               }
           ?>

      </div>
      <div class='profile-right_column'>
           <div class='profile-right_column-header'>

                     <?php echo $model->username ?> /
                     Status: <?php echo ($model->profile->active == 1) ? ('active') : ('not active'); ?> /
                     Comments: <?php echo ($model->profile->commentPermission == 1) ? ('allowed') : ('not allowed'); ?>

           </div>

           <div class='profile-right_column-content'>
                E-mail: <?php echo $model->email ?><br/>
                <?php
                    if(!empty($model->profile->birthday)){
                         echo 'Date of Birth: '.$model->profile->birthday.'<br/>';
                    }
                    if(!empty($model->profile->phone)){
                         echo 'Phone: '.$model->profile->phone.'<br/>';
                    }
                    if(!empty($model->profile->address)){
                         echo 'Address: '.$model->profile->address.'<br/>';
                    }
                ?>
                <hr/><br/>
                <?php
                    if($model->id == Yii::$app->user->id){
                         echo Html::a('New post', [Url::toRoute(['posts/create'])], ['class' => 'btn btn-content']);
                    }
                ?>
                <?= Html::a('Reset search', [Url::toRoute(['index', 'id' => $model->id])], ['class' => 'btn btn-content']) ?><br/><br/>
                <?=
                     GridView::widget([
                          'dataProvider' => $dataProvider,
                          'filterModel' => $searchModel,
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
                                 'triggerText' => 'Load more posts...',
                                 'noneLeftText' => 'End of page',
                                 'triggerOffset' => $loadCount,
                                 'noneLeftTemplate' => '',
                                 'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer"><div class="btn btn-content">{text}</div></a></td></tr>',
                          ],
                          'columns' => [
                              [
                                   'class' => DataColumn::className(),
                                   'attribute' => 'title',
                                   'label' => 'Search by title',
                                   'format' => 'html',
                                   //'header' => 'Name',
                                   'value' => function($model){
                                        $buttonUpdate = "";
                                        $buttonDelete = "";
                                        /*
                                        $listView = "";
                                        if($model->commentsCount != 0){
                                             $listView = "<br/><div class='comments'>".ListView::widget([
                                                  'dataProvider' => $model->postComments,
                                                  'summary' => false,
                                                  //'itemOptions' => ['class' => 'item'],
                                                  'itemView' => 'lists/comments',
                                                  //'pager' => ['class' => ScrollPager::className()],
                                             ])."</div>";
                                        }
                                        */
                                        if($model->userId == Yii::$app->user->id){
                                             $buttonUpdate = " | ".Html::a('Update', [Url::toRoute(['posts/update', 'id' => $model->id])])." | ";
                                             $buttonDelete = Html::a('Delete', [Url::toRoute(['posts/delete', 'id' => $model->id])]);
                                        }
                                        $resultString = "
                                             <div class='searchWrapper'>
                                                  <h4>".$model->title."</h4>
                                                  <hr/>
                                                  <h4>Entire post:</h4>
                                                  ".$model->content."
                                                  <hr/>
                                             Created: ".$model->dateCreate." | Updated: ".$model->dateUpdate." | Comments: ".$model->commentsCount."
                                             | ".Html::a('Add comment', Url::toRoute(['comment', 'id' => $model->id]))." ".$buttonUpdate." ".$buttonDelete."
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
</div>
