<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class='commentWrapper'>
     <div class='searchLeftColumn'>
          <?= Html::img(Url::toRoute($model->user->profilePicture), ['width' => '80px']) ?>
     </div>
     <div class='searchMiddleColumn'>
          Username: <?php echo Html::a(HtmlPurifier::process($model->user->username), [Url::toRoute(['index', 'id' => $model->user->id])]); ?><br/>
          Comment: <?php echo $model->message; ?>
     </div>
     <div class='searchRightColumn'>
          <?php
               if(Yii::$app->user->id == $model->user->id){
                    echo Html::a('Delete comm.', [Url::toRoute(['deletecomment', 'id' => $model->id])], ['class' => 'btn btn-info']);
               }
          ?>
     </div>
</div>
