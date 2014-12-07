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
    <!-- 3 events -->
    <h1>Past events</h1>
    <div class="row next-events">
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#EventHashTag</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> December 21, 2014</span>
                </h2>
                <h3><a href="#">Event name</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="holder.js/100%x100" alt="{Event name}">
                </a>
            </header>
            <p>
                Lorem ipsum dolor sit amet, vocent convenire id cum, pro id eros tempor. Esse nonumes pri te, cum ubique gubergren ut
                <strong>#EventHashTag</strong>
            </p>
        </div>
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#EventHashTag</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> December 21, 2014</span>
                </h2>
                <h3><a href="#">Event name</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="holder.js/100%x100" alt="{Event name}">
                </a>
            </header>
            <p>
                Lorem ipsum dolor sit amet, vocent convenire id cum, pro id eros tempor. Esse nonumes pri te, cum ubique gubergren ut
                <strong>#EventHashTag</strong>
            </p>
        </div>
        <div class="col-md-4">
            <header>
                <h2>
                    <span class="tag">#EventHashTag</span>
                    <span class="date"><i class="glyphicon glyphicon-calendar"></i> December 21, 2014</span>
                </h2>
                <h3><a href="#">Event name</a></h3>

                <a href="#" class="thumbnail">
                    <img data-src src="holder.js/100%x100" alt="{Event name}">
                </a>
            </header>
            <p>
                Lorem ipsum dolor sit amet, vocent convenire id cum, pro id eros tempor. Esse nonumes pri te, cum ubique gubergren ut
                <strong>#EventHashTag</strong>
            </p>
        </div>
    </div>

    <hr>

    <br><br><br>
</div>

<?php $this->registerJsFile('/js/social-login.js', ['depends' => ['yii\web\JqueryAsset']]);
