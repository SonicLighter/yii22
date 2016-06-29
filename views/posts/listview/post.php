<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="news-item">
    <hr/>
    <h2><?= Html::encode($model->title) ?></h2>
    <hr/>
    <h4>Description:</h4>
    <?= HtmlPurifier::process($model->description) ?>
    <h4>Entire post:</h4>
    <?= HtmlPurifier::process($model->text) ?>
    <p>
     <br/> Created: <?= HtmlPurifier::process($model->dateCreate) ?> | Updated: <?= HtmlPurifier::process($model->dateUpdate) ?>
     | <a href='update?id=<?php echo $model->id ?>'> Update Post </a> | <a href='delete?id=<?php echo $model->id ?>'> Delete Post </a>
    </p>
</div>
<hr/>
