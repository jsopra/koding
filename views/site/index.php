<?php
use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
$this->title = 'Social Warming - Create mass awareness for social causes on the day of the event';
?>
<div class="wrap featured" style="background-image: url('/img/human-rights-day_mini.jpg')">
    <div class="container">
        <header>
            <h1><span>Next event</span> Human rights day</h1><br>
            <h2>#HumanRightsDay</h2>
            <h3>Ignite the social fire on <span>10<sup>th</sup> December</span></h3>
            <?php if (Yii::$app->user->isGuest) : ?>
            <div class="social-wrap c">
                <button data-social-login data-social-name="facebook" class="facebook">Join with Facebook</button>
                <button data-social-login data-social-name="twitter" class="twitter">Join with Twitter</button>
            </div>
            <div style="display: none">
            <?= AuthChoice::widget(['baseAuthUrl' => ['site/auth']]); ?>
            </div>
            <?php endif; ?>
        </header>
    </div>
</div>

<div class="container">
    aaa
</div>

<?php $this->registerJsFile('/js/social-login.js', ['depends' => ['yii\web\JqueryAsset']]);