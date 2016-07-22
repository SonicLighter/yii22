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
use yii\bootstrap\Button;

$this->title = $model->username;
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-profile">
      <div class='profile-left_column'>
           <?php

               //echo Html::a("<i class='glyphicon glyphicon-eye-close'></i> My Profile", 'options' => [ 'url' => 'profile/index', 'class' => 'btn btn-profile-menu']);
               echo Html::a("<i class='glyphicon glyphicon-home'></i> &nbsp My Profile", Url::toRoute(['profile/index', 'id' => Yii::$app->user->id]), ['class'=>'btn btn-profile-menu']);
               echo Html::a("<i class='glyphicon glyphicon-envelope'></i> &nbsp Messages (".Yii::$app->user->identity->myMessages.")", [Url::toRoute(['/messages/index'])], ['class' => 'btn btn-profile-menu']);
               echo Html::a("<i class='glyphicon glyphicon-user'></i> &nbsp My Friends", Url::toRoute(['profile/friends']), ['class'=>'btn btn-profile-menu']);
               echo Html::a("<i class='glyphicon glyphicon-time'></i> &nbsp New Friends (".$waitingCount.")", [Url::toRoute(['waiting'])], ['class' => 'btn btn-profile-menu']);
               echo Html::a("<i class='glyphicon glyphicon-star'></i> &nbsp My Requests (".$notAcceptedCount.")", [Url::toRoute(['requests'])], ['class' => 'btn btn-profile-menu']);

           ?>
      </div>
      <div class='profile-middle_column'>
           <?= Html::img(Url::toRoute($model->profilePicture), ['width' => '100%']) ?>
           <br/><br/>
           <?php
               if($model->id == Yii::$app->user->id){
                    echo Html::a("Settings", [Url::toRoute(['edit'])], ['class' => 'btn btn-profile-menu-selected']);
               }
               else{
                    echo Html::a("Send message", [Url::toRoute(['messages/view', 'id' => $model->id])] , ['class' => 'btn btn-profile-menu-selected']);
                    if(empty($model->friend)){
                         echo Html::a("Add to friends", [Url::toRoute(['invite', 'id' => $model->id])], ['class' => 'btn btn-profile-menu-selected']);
                    }
                    else{
                         if(!empty($model->receiver) && ($model->receiver->accepted == 0)){
                              echo Html::a("Accept user&nbsp", [Url::toRoute(['accept', 'id' => $model->id])], ['class' => 'btn btn-profile-menu-selected']);
                         }
                         echo Html::a("Delete friend", [Url::toRoute(['remove', 'id' => $model->id])], ['class' => 'btn btn-profile-menu-selected']);
                    }
               }
           ?>

      </div>
      <div class='profile-right_column'>
           <div class='profile-right_item'>
                <div class='profile-right_item-username'>
                     <?php echo $model->username ?>
                </div>
                <div class='profile-right_item-active'>
                     <?php echo ($model->profile->active == 1) ? ('Active') : ('Not active'); ?>
                </div>
                <br/><hr/>
                <div class='profile-right_item-info'>
                     E-mail:
                </div>
                <div class='profile-right_item-infovalue'>
                     <?php echo $model->email ?>
                </div><br/>

                <?php
                    if(!empty($model->profile->birthday)){
                         echo '<div class="profile-right_item-info">Date of Birth:</div><div class="profile-right_item-infovalue">'.$model->profile->birthday.'</div><br/>';
                    }
                    if(!empty($model->profile->phone)){
                         echo '<div class="profile-right_item-info">Phone:</div><div class="profile-right_item-infovalue">'.$model->profile->phone.'</div><br/>';
                    }
                    if(!empty($model->profile->address)){
                         echo '<div class="profile-right_item-info">Address:</div><div class="profile-right_item-infovalue">'.$model->profile->address.'</div><br/>';
                    }
                ?>
                <?php
                    if($model->id == Yii::$app->user->id){
                         echo "<br/><hr/>";
                         echo Html::a("<i class='glyphicon glyphicon-pencil'></i> New post", [Url::toRoute(['posts/create'])]);
                    }
                ?>
                <br/>
           </div>
                <div class='profile-right_column-content'>
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
                                             <div class='newsWrapper'>
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
