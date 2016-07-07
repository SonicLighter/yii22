<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class='searchWrapper'>
     <div class='searchLeftColumn'>
          <?= Html::img(Url::toRoute($model->profilePicture), ['width' => '85%']) ?>
     </div>
     <div class='searchMiddleColumn'>
          <h4>Username: <?= HtmlPurifier::process($model->username) ?></h4>

          E-mail: <?= HtmlPurifier::process($model->email) ?><br/>

          Role: <?= HtmlPurifier::process($model->role->item_name) ?>

     </div>
     <div class='searchRightColumn'>
          <?= Html::a('Add to friends', [Url::toRoute(['invite', 'id' => $model->id])], ['class' => 'btn btn-info']) ?>
     </div>
</div>
