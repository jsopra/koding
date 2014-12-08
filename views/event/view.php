<?php

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\helpers\Inflector;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 event-view next-events">
        <header>
            <h2>
                <span class="tag"><?= Html::encode($model->hashtag) ?></span>
            </h2>
            <h3>
                <?= Html::encode($model->name) ?>
                <span class="date">
                <i class="glyphicon glyphicon-calendar"></i>
                    <?= Yii::$app->formatter->asDate($model->occurred_on) ?>
            </span>
            </h3>
            <?=
            Html::img(
                Yii::$app->resourceManager->getUrl($model->image_name),
                ['alt' => Html::encode($model->name)]
            )
            ?>
        </header>

        <p><?= nl2br(Html::encode($model->description)) ?></p>

        <footer>
            <div class="text-muted">
                <div class="row">
                    <div class="col-md-6">
                        <i class="glyphicon glyphicon-fire icon-shared"></i>
                        <?= Yii::$app->formatter->asInteger($model->joined_users_counter) ?> people shared
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <i class="glyphicon glyphicon-eye-close icon-awareness"></i>
                            <?= Yii::$app->formatter->asInteger($model->awareness_created_counter) ?> direct awareness
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="col-md-4">

    </div>
</div>


<div class="event-view next-events">
    <?php if (false == $model->isPast()) : ?>
    <div>
    <?php if (Yii::$app->user->isGuest) : ?>
        <?= AuthChoice::widget([
            'baseAuthUrl' => ['site/auth', 'event_id' => $model->id]
        ]) ?>
    <?php elseif (Yii::$app->user->identity->hasJoinedEvent($model)) : ?>
        <?= Html::a(
            'Joined',
            ['event/unjoin', 'id' => $model->id, 'url' => Inflector::slug($model->name)],
            ['class' => 'btn btn-default']
        ) ?>
    <?php else : ?>
        <?= Html::a(
            'Join',
            ['event/join', 'id' => $model->id, 'url' => Inflector::slug($model->name)],
            ['class' => 'btn btn-primary']
        ) ?>
    <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($recentJoinings) : ?>
    <section>
        <h2>People who joined</h2>
        <ul>
            <?php foreach ($recentJoinings as $recentJoin) : ?>
            <li>
                <?= $recentJoin->user->first_name ?>
                <time datetime="<?= $recentJoin->joined_at ?>">
                    <?= Yii::$app->formatter->asRelativeTime($recentJoin->joined_at) ?>
                </time>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if ($eventChart->hasTopCountriesData() || $eventChart->hasSocialNetworksData()) : ?>
    <div class="row">
        <?php if ($eventChart->hasTopCountriesData()): ?>
        <div class="col-sm-6">
            <h3>Top Countries</h3>
            <?= Highcharts::widget([
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'borderColor' => '#EEEEEE',
                        'borderWidth' => 1,
                    ],
                    'title' => ['text' => ''],
                    'xAxis' => [
                        'categories' => $eventChart->getXAxisBySocialNetworkAndCountry(),
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => ['text' => 'Sharings'],
                        'stackLabels' => [
                            'enabled' => true,
                            'color' => 'gray',
                        ],
                    ],
                    'legend' => [
                        'align' => 'right',
                        'x' => -70,
                        'verticalAlign' => 'top',
                        'y' => 20,
                        'floating' => true,
                        'borderColor' => '#CCC',
                        'borderWidth' => 1,
                        'shadow' => false,
                        'backgroundColor' => '#FFF',
                    ],
                    'tooltip' => ['format' => '{point.x}'],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'textShadow' => '0 0 3px black, 0 0 3px black',
                                    'color' => '#FFF',
                                ],
                            ],
                        ],
                    ],
                    'series' => $eventChart->getSeriesBySocialNetworkAndCountry(),
                ]
            ]) ?>
        </div>
        <?php endif; ?>

        <?php if ($eventChart->hasSocialNetworksData()) : ?>
        <div class="col-sm-6">
            <h3>Social Networks</h3>
            <?= Highcharts::widget([
                'options' => [
                    'chart' => [
                        'borderColor' => '#EEEEEE',
                        'borderWidth' => 1,
                        'plotBackgroundColor' => null,
                        'plotBorderWidth' => 0,
                        'plotShadow' => false,
                        'margin' => 0,
                    ],
                    'title' => [ 'text' => ''],
                    'plotOptions' => [
                        'pie' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'fontWeight' => 'bold',
                                    'fontSize' => '16px',
                                    'color' => '#333333',
                                    'textAlign' => 'center',
                                ],
                                'format' => '{point.name}<br />{point.y:,.0f}',
                            ],
                            'startAngle' => -90,
                            'endAngle' => 90,
                            'center' => ['50%', '75%'],
                        ],
                    ],
                    'series' => [
                        [
                            'type' => 'pie',
                            'name' => 'Sharings',
                            'innerSize' => '50%',
                            'data' => $eventChart->getSharingsBySocialNetwork(),
                        ]
                    ],
                ]
            ]) ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
