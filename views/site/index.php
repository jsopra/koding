<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
            <div class="social-wrap">
                <button data-social-login data-social-name="facebook" class="button facebook">Join with Facebook</button>
                <button data-social-login data-social-name="twitter" class="button twitter">Join with Twitter</button>
            </div>
            <div style="display: none">
                <?= AuthChoice::widget(['baseAuthUrl' => ['site/auth']]); ?>
            </div>
            <?php else: ?>
                <div class="under-header">
                    Thank you! Now ask your friends to join.

                    <div class="social-wrap c">
                        <a href="https://www.facebook.com/dialog/feed?link=<?= Url::base(true) ?>&app_id=1521379368146035&display=popup&caption=<?= urlencode('Help raise awareness on social events and causes. Join #socialwarming') ?>&redirect_uri=<?= Url::base(true) ?>"
                           class="button facebook small primary-color"
                           target="_blank">Invite your friends</a>
                        <a href="http://www.twitter.com/share?url=<?= Url::base(true) ?>&text=<?= urlencode('Help raise awareness on social events and causes. Join #socialwarming') ?>&"
                           class="button twitter small primary-color"
                           target="_blank">Invite your friends</a>
                    </div>
                </div>
            <?php endif; ?>
        </header>
    </div>
    <div class="bar">
        12,344 people will share this event on 10<sup>th</sup> December!
    </div>
</div>

<div class="container">
    aaa
</div>

<?php $this->registerJsFile('/js/social-login.js', ['depends' => ['yii\web\JqueryAsset']]);
