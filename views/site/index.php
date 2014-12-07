<?php
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;
use miloschuman\highcharts\HighchartsAsset;

/* @var $this yii\web\View */
$this->title = 'Social Warming - Create mass awareness for social causes on the day of the event';

HighchartsAsset::register($this)->withScripts([
    'highcharts',
    'highcharts-more',
    'modules/map',
    'modules/data',
    'modules/exporting',
]);

$this->registerJs("renderMap();", View::POS_READY);
$this->registerJsFile(
    Url::base() . '/js/highcharts-mapdata-custom-world.js',
    ['position' => View::POS_END, 'depends' => HighchartsAsset::className()]
);
?>
<?php if ($featuredEvent) : ?>
<div class="wrap featured" style="background-image: url('<?= Yii::$app->resourceManager->getUrl($featuredEvent->image_name) ?>')">
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

        <div class="align-center">
            <button class="btn btn-default status-preview-button">Preview status messages</button>
        </div>

        <div class="row previews hide status-preview-holder">
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
            <?= $this->render('/event/_view', ['model' => $event]) ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <hr>
</div>

<div class="container">
    <h2 class="text-center">People accross the world who joined Social Warming</h2>
    <div id="map-container">Loading map...</div>
    <script>
    function renderMap()
    {
        var mapData = Highcharts.geojson(Highcharts.maps["custom/world"]);
        var chartData = <?= Json::encode($userChart->getJoinedUsersByCountry()) ?>;

        // Correct UK to GB in data
        $.each(chartData, function () {
            if (this.country === 'UK') {
                this.country = 'GB';
            }
        });

        $('#map-container').highcharts('Map', {
            chart : { borderWidth : 0 },
            legend: { enabled: false },
            title: { text: '' },
            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            series : [{
                name: 'Countries',
                mapData: mapData,
                color: '#FF0000',
                enableMouseTracking: false
            }, {
                type: 'mapbubble',
                mapData: mapData,
                name: 'People',
                joinBy: ['iso-a2', 'country'],
                data: chartData,
                minSize: 4,
                maxSize: '12%',
                pointArrayMap: ['value'],
                tooltip: {
                    pointFormat: '{point.country}: {point.value} people'
                }
            }]
        });
    }
    </script>

    <hr>

    <br><br><br>
</div>

<?php $this->registerJsFile('/js/homepage.js', ['depends' => ['yii\web\JqueryAsset']]); ?>
