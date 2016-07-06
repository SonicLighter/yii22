<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="news-item">
    <hr/>
    <h2><?= Html::encode($model->username) ?></h2>
    <?= Html::img(Url::toRoute($model->profilePicture), ['width' => '100px']) ?>
</div>
<hr/>
