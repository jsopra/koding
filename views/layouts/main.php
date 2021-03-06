<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\authclient\widgets\AuthChoice;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <!-- Facebook Meta -->
    <meta property="og:image" content="<?= Url::base(true) ?>/img/emblem.png"/>
    <meta property="og:title" content="<?= Html::encode($this->title) ?>"/>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-1929568-54', 'auto');
        ga('send', 'pageview');

    </script>

    <?php $this->head() ?>
</head>
<body class="<?= preg_replace('/[^\da-z]/i', '', Yii::$app->request->url) ?: 'homepage' ?>">
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' =>
                    Html::img('/img/emblem-64.png', ['title' => 'Social Warming']) .
                    '<span class="logo-label">Social Warming</span>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-static-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index'], 'options' => ['class' => 'home-link']],
                ['label' => 'Events', 'url' => ['/event/index']],
                ['label' => 'About', 'url' => ['/site/about']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = [
                    'label' => 'Join with Facebook',
                    'url' => '#',
                    'options' => ['class' => 'social-wrap'],
                    'linkOptions' => [
                        'class' => 'button facebook',
                        'data-social-login' => '',
                        'data-social-name' => 'facebook',
                    ],
                ];
                $menuItems[] = [
                    'label' => 'Join with Twitter',
                    'url' => '#',
                    'options' => ['class' => 'social-wrap'],
                    'linkOptions' => [
                        'class' => 'button twitter',
                        'data-social-login' => '',
                        'data-social-name' => 'twitter',
                    ],
                ];
            } else {
                $menuItems[] = [
                    'label' => 'Invite your friends',
                    'url' => 'https://www.facebook.com/dialog/feed?link=' . Url::base(true) . '&app_id=1521379368146035&display=popup&caption=' . urlencode('Help raise awareness on social events and causes. Join #socialwarming') . '&redirect_uri=' . Url::base(true),
                    'options' => ['class' => 'social-wrap'],
                    'linkOptions' => ['class' => 'button facebook small primary-color', 'target' => '_blank'],
                ];
                $menuItems[] = [
                    'label' => 'Invite your friends',
                    'url' => 'http://www.twitter.com/share?url=' . Url::base(true) . '&text=' . urlencode('Help raise awareness on social events and causes. Join #socialwarming') . '&',
                    'options' => ['class' => 'social-wrap c'],
                    'linkOptions' => ['class' => 'button twitter small primary-color', 'target' => '_blank'],
                ];
                $menuItems[] = [
                    'label' => 'Account',
                    'url' => ['/profile/index']
                ];
                $menuItems[] = [
                    'label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);

            NavBar::end();
        ?>

        <?php if (Yii::$app->homeUrl == Yii::$app->request->url) : ?>
            <?= $content ?>
        <?php else : ?>
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>

                <?= $content ?>
            </div>
        <?php endif; ?>
        <hr>
    </div>


    <footer class="footer">
        <div class="container">
        <p class="pull-left"></p>
        <p class="pull-right"></p>
        </div>
    </footer>

    <div style="display: none">
        <?= AuthChoice::widget(['baseAuthUrl' => ['site/auth']]); ?>
    </div>


    <?php
        $this->registerJsFile('/js/social-login.js', ['depends' => ['yii\web\JqueryAsset']]);
    ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
