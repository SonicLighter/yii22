<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class='commentWrapper'>
     <div class='commentLeftColumn'>
          <?= Html::img(Url::toRoute($model->user->profilePicture), ['width' => '120px']) ?>
     </div>
     <div class='commentMiddleColumn'>
          Username: <?php echo Html::a(HtmlPurifier::process($model->user->username), [Url::toRoute(['index', 'id' => $model->user->id])]); ?><br/>
          Comment: <?php echo $model->message; ?>
     </div>
     <div class='commentRightColumn'>
          <?php
               if(Yii::$app->user->id == $model->user->id){
                    echo Html::a('Delete', [Url::toRoute(['deletecomment', 'id' => $model->id])], ['class' => 'btn btn-info']);
               }
          ?>
     </div>
</div>
