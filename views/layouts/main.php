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
        'brandLabel' => 'SOCIALNETWORK.COM',
        'brandUrl' => (Yii::$app->user->isGuest)?(Yii::$app->homeUrl):(Url::toRoute(['profile/index', 'id' => Yii::$app->user->id])),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                 'label' => 'AdminPanel',
                 'url' => ['/admin'],
                 'visible' =>  Yii::$app->user->can("openUsers"),
            ],
            [
                 'label' => 'Search',
                 'url' => ['/profile/search'],
                 'visible' => !Yii::$app->user->isGuest,
            ],
            /*
            [
                  'label' => 'Posts',
                  'url' => ['/posts/index'],
                  'visible' => !Yii::$app->user->isGuest,
            ],
            */
            /*
            [
                 'label' => 'Home',
                 'url' => ['/site/index']
             ],
            [
                 'label' => 'About',
                 'url' => ['/site/about']
            ],
            [
                 'label' => 'Contact',
                 'url' => ['/site/contact']
            ],
            */
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                //'<a href="#">Пункт с подпунктами 1<span class="navbar-nav navbar-right"></span></a>'

                [
                     'label' => Yii::$app->user->identity->username,
                     'options' => ['class' => 'navbar-nav navbar-right'],
                     'items' => [
                         ['label' => 'My Profile', 'url' => Url::toRoute(['/profile/index', 'id' => Yii::$app->user->id])],
                         ['label' => 'Friends', 'url' => '/profile/friends'],
                         ['label' => 'Messages ('.Yii::$app->user->identity->myMessages.')', 'url' => '/messages/index'],
                         ['label' => 'Settings', 'url' => '/profile/edit'],
                         ['label' => 'Logout (' . Yii::$app->user->identity->email . ')', 'url' => '/site/logout'],
                     ],
                ]

               /*
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
                */
            )
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
