<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                 'label' => 'Users',
                 'url' => ['/users/index'],
                 'visible' =>  Yii::$app->user->can("openUsers"),
            ],
            [
                 'label' => 'Roles',
                 'url' => ['/roles/index'],
                 'visible' => Yii::$app->user->can("openRoles"),
            ],
            [
                  'label' => 'Posts',
                  'url' => ['/posts/index'],
                  'visible' => !Yii::$app->user->isGuest,
            ],
            [
                 'label' => 'Search',
                 'url' => ['/profile/search'],
                 'visible' => !Yii::$app->user->isGuest,
            ],
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
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                //'<a href="#">Пункт с подпунктами 1<span class="navbar-nav navbar-right"></span></a>'

                [
                     'label' => Yii::$app->user->identity->username,
                     'options' => ['class' => 'navbar-nav navbar-right'],
                     'items' => [
                         ['label' => 'My Profile', 'url' => '/profile/index'],
                         ['label' => 'Friends', 'url' => '/profile/friends'],
                         '<li>'
                         . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                         . Html::submitButton(
                             'Logout (' . Yii::$app->user->identity->email . ')',
                             ['class' => 'btn btn-default']
                         )
                         . Html::endForm()
                         . '</li>'
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
