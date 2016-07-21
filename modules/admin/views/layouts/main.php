<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use bluezed\scrollTop\ScrollTop;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<?= ScrollTop::widget() ?>
    <?php
    NavBar::begin([
        'brandLabel' => 'ADMINPANEL',
        'brandUrl' => (Yii::$app->user->isGuest)?(Yii::$app->homeUrl):(Url::toRoute(['main/index'])),
        'options' => [
           // 'class' => 'nav nav-tabs nav-justified',
           'class' => 'navbar navbar-default navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                  'label' => 'View sait',
                  'url' => ['../'],
                  'visible' =>  Yii::$app->user->can("openUsers"),
                  'title' => 'Open website',
            ],
            [
                 'label' => 'Users',
                 'url' => ['users/index'],
                 'visible' =>  Yii::$app->user->can("openUsers"),
            ],
            [
                 'label' => 'Roles',
                 'url' => ['roles/index'],
                 'visible' => Yii::$app->user->can("openRoles"),
            ],
            [
                 'label' => 'Logout',
                 'url' => ['../site/logout'],
                 'visible' => Yii::$app->user->can("openUsers"),
            ],
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; SOCIALNETWORK <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
