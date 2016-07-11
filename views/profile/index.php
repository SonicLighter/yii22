<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\DataColumn;

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
                    echo Html::a("<div class='userMenu'>Set Profile Picture</div>", [Url::toRoute(['picture'])]);
                    echo Html::a("<div class='userMenu'>New Friends (".$waitingCount.")</div>", [Url::toRoute(['waiting'])]);
                    echo Html::a("<div class='userMenu'>My Requests (".$notAcceptedCount.")</div>", [Url::toRoute(['requests'])]);
               }
               else{
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

                     Username: <?php echo $model->username ?> /
                     E-mail: <?php echo $model->email ?> /
                     Profile status: <?php echo ($model->active == 1) ? ('active') : ('not active'); ?>

           </div>
           <div class='profile-right_column-content'>
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
                          'tableOptions' => [
                              'class' => 'myGridView', /*table table-striped table-bordered*/
                          ],
                          /*
                          'rowOptions' => [
                               'style' => 'border: 0px solid',
                          ],
                          */
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
                                        if($model->userId == Yii::$app->user->id){
                                             $buttonUpdate = " | ".Html::a('Update', [Url::toRoute(['posts/update', 'id' => $model->id])])." | ";
                                             $buttonDelete = Html::a('Delete', [Url::toRoute(['posts/delete', 'id' => $model->id])]);
                                        }
                                        $resultString = "
                                             <div class='searchWrapper'>
                                                  <h4>".$model->title."</h4>
                                                  <hr/>
                                                  <h4>Entire post:</h4>
                                                  ".$model->text."
                                                  <hr/>
                                             Created: ".$model->dateCreate." | Updated: ".$model->dateUpdate." ".$buttonUpdate." ".$buttonDelete."
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
