<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Social Warming - Create mass awareness for social causes on the day of the event';
?>
<?php if ($featuredEvent) : ?>
<div class="wrap featured" style="background-image: url('/img/human-rights-day_mini.jpg')">
    <div class="container">
        <header>
            <h1><span>Next event</span> <?= Html::encode($featuredEvent->name) ?></h1><br>
            <h2><?= $featuredEvent->hashtag ?></h2>
            <h3>
                Ignite the social fire on
                <span><?= Yii::$app->formatter->asDate($featuredEvent->occurred_on) ?></span>
            </h3>
            <?php if (Yii::$app->user->isGuest) : ?>
            <div class="social-wrap">
                <button data-social-login data-social-name="facebook" class="button facebook">Join with Facebook</button>
                <button data-social-login data-social-name="twitter" class="button twitter">Join with Twitter</button>
            </div>
            <?php elseif (Yii::$app->user->identity->hasJoinedEvent($featuredEvent)) : ?>
                <div class="under-header">
                    Thank you for participating! Now ask your friends to join:

                    <div class="social-wrap c">
                        <a href="https://www.facebook.com/dialog/feed?link=<?= Url::base(true) ?>&app_id=1521379368146035&display=popup&caption=<?= urlencode('Help raise awareness on social events and causes. Join #socialwarming') ?>&redirect_uri=<?= Url::base(true) ?>"
                           class="button facebook small primary-color"
                           target="_blank">Invite your friends</a>
                        <a href="http://www.twitter.com/share?url=<?= Url::base(true) ?>&text=<?= urlencode('Help raise awareness on social events and causes. Join #socialwarming') ?>&"
                           class="button twitter small primary-color"
                           target="_blank">Invite your friends</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="social-wrap">
                    <?= Html::a(
                        'Join now',
                        ['event/join', 'id' => $featuredEvent->id, 'url' => Inflector::slug($featuredEvent->name)],
                        ['class' => 'button join']
                    ) ?>
                </div>
            <?php endif; ?>
        </header>
    </div>
    <div class="bar">
        <?= Yii::$app->formatter->asInteger($featuredEvent->joined_users_counter) ?>
        people will share this event on
        <?= Yii::$app->formatter->asDate($featuredEvent->occurred_on) ?>
    </div>
</div>
<?php endif; ?>

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

    <?php if ($pastEvents) : ?>
    <h1>Past events</h1>
    <div class="row next-events">
        <?php foreach ($pastEvents as $event) : ?>
        <div class="col-sm-4">
            <header>
                <h2>
                    <span class="tag"><?= $event->hashtag ?></span>
                    <span class="date">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <?= Yii::$app->formatter->asDate($event->occurred_on) ?>
                    </span>
                </h2>
                <h3>
                    <?= Html::a(
                        Html::encode($event->name),
                        ['event/view', 'id' => $event->id, 'url' => Inflector::slug($event->name)]
                    ) ?>
                </h3>

                <?= Html::a(
                    Html::img(
                        Yii::$app->resourceManager->getUrl($event->thumbnail_name),
                        ['alt' => $event->name]
                    ),
                    ['event/view', 'id' => $event->id, 'url' => Inflector::slug($event->name)],
                    ['class' => 'thumbnail']
                ) ?>
            </header>
            <p><?= nl2br(StringHelper::truncateWords(Html::encode($event->description), 54)) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <hr>

    <br><br><br>
</div>
