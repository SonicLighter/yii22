<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="news-item">
    <hr/>
    <h2><?= Html::encode($model->title) ?></h2>
    <hr/>
    <h4>Entire post:</h4>
    <?= HtmlPurifier::process($model->content) ?>
    <p>
     <br/> Created: <?= HtmlPurifier::process($model->dateCreate) ?> | Updated: <?= HtmlPurifier::process($model->dateUpdate) ?>
     | <a href=<?php echo Url::toRoute(['update', 'id' => $model->id]); ?>> Update Post </a> | <a href=<?php echo Url::toRoute(['delete', 'id' => $model->id]); ?>> Delete Post </a>
    </p>
</div>
<hr/>
