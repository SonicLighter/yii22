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
                    echo Html::a("<div class='userMenu'>Edit Profile</div>", [Url::toRoute(['edit'])]);
                    echo Html::a("<div class='userMenu'>New Friends (".$waitingCount.")</div>", [Url::toRoute(['waiting'])]);
                    echo Html::a("<div class='userMenu'>My Requests (".$notAcceptedCount.")</div>", [Url::toRoute(['requests'])]);
               }
               else{
                    echo Html::a("<div class='userMenu'>Send message</div>", [Url::toRoute(['messages/view', 'id' => $model->id])]);
                    if(empty($model->friend)){
                         echo Html::a("<div class='userMenu'>Add to friends</div>", [Url::toRoute(['invite', 'id' => $model->id])]);
                    }
                    else{
                         if(!empty($model->receiver) && ($model->receiver->accepted == 0)){
                              echo Html::a("<div class='userMenu'>Accept user&nbsp</div>", [Url::toRoute(['accept', 'id' => $model->id])]);
                         }
                         echo Html::a("<div class='userMenu'>Delete friend</div>", [Url::toRoute(['remove', 'id' => $model->id])]);
                    }
               }
           ?>

      </div>
      <div class='profile-right_column'>
           <div class='profile-right_column-header'>

                     <?php echo $model->username ?> /
                     Status: <?php echo ($model->active == 1) ? ('active') : ('not active'); ?> /
                     Comments: <?php echo ($model->commentPermission == 1) ? ('allowed') : ('not allowed'); ?>

           </div>

           <div class='profile-right_column-content'>
                E-mail: <?php echo $model->email ?><br/>
                <?php
                    if(!empty($model->birthday)){
                         echo 'Date of Birth: '.$model->birthday.'<br/>';
                    }
                    if(!empty($model->phone)){
                         echo 'Phone: '.$model->phone.'<br/>';
                    }
                    if(!empty($model->address)){
                         echo 'Address: '.$model->address.'<br/>';
                    }
                ?>
                <hr/><br/>
                <?php
                    if($model->id == Yii::$app->user->id){
                         echo Html::a('New post', [Url::toRoute(['posts/create'])], ['class' => 'userMenu']);
                    }
                ?>
                <?= Html::a('Reset search', [Url::toRoute(['index', 'id' => $model->id])], ['class' => 'userMenu']) ?><br/><br/>
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
                                 'noneLeftTemplate' => '<div class="ias-noneleft" style="text-align: center;"><div class="userMenu">{text}</div></div>',
                                 'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer"><div class="userMenu">{text}</div></a></td></tr>',
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
