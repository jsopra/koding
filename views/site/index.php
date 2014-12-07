<?php
use yii\helpers\Html;
use yii\helpers\Url;

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
    <div class="bs-callout bs-callout-primary">
        <h4>What happens if you join?</h4>
        <p>On the day of the event we will update your Twitter or Facebook status to raise awareness about the current event.</p>

        <hr>

        <div class="row previews">
            <div class="col-md-6">
                <h5>Twitter status preview</h5>
                <div class="thumbnail">
                    <img src="/img/preview-twitter.png" alt="Preview Twitter event sharing">
                </div>
            </div>
            <div class="col-md-6">
                <h5>Facebook status preview</h5>
                <div class="thumbnail">
                    <img src="/img/preview-facebook.png" alt="Preview Twitter event sharing">
                </div>
            </div>
        </div>
    </div>

    <!-- 3 events -->
    <h1>Past events</h1>
    <div class="row next-events">
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#ChildrensDay</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> November 20, 2014</span>
                </h2>
                <h3><a href="#">Universal Children's Day</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="img/world-childrens-day.jpg" alt="World Children's Day">
                </a>
            </header>
            <p>
                There is much to celebrate as we mark the 25th anniversary of the Convention, from declining infant mortality to rising school enrolment, but this historic milestone must also serve as an urgent reminder that much remains to be done. Too many children still do not enjoy their full rights on par with their peers.
            </p>
        </div>
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#WorldDiabetesDay</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> November 14, 2014</span>
                </h2>
                <h3><a href="#">World Diabetes Day</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="/img/world-diabetes-day.png" alt="World Diabetes Day">
                </a>
            </header>
            <p>
                World Diabetes Day unites the global diabetes community to produce a powerful voice for diabetes awareness and advocacy, engaging individuals and communities to bring the diabetes epidemic into de public spotlight.

                Led by the International Diabetes Federation, the day unites the global diabetes community to produce a powerful voice for diabetes awareness and advocacy.
            </p>
        </div>
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#WorldAnimalDay</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> October 4, 2014</span>
                </h2>
                <h3><a href="#">World Animal Day</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="/img/world-animal-day-large.jpg" alt="World Animal Day">
                </a>
            </header>
            <p>
                World Animal Day has become a day for remembering and paying tribute to all animals and the people who love and respect them. It's celebrated in different ways in every country, with no regard to nationality, religion, faith or political ideology.
            </p>
        </div>
    </div>

    <hr>

    <br><br><br>
</div>

<?php $this->registerJsFile('/js/social-login.js', ['depends' => ['yii\web\JqueryAsset']]);
