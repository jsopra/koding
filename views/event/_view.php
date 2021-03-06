<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var $model \app\models\Event
 */
?>
<div class="col-sm-4 event-widget">
    <header>
        <h2>
            <span class="tag"><?= Html::encode($model->hashtag) ?></span>
            <span class="date">
                <i class="glyphicon glyphicon-calendar"></i>
                <?= Yii::$app->formatter->asDate($model->occurred_on) ?>
            </span>
        </h2>
        <h3>
            <?= Html::a(
                Html::encode($model->name),
                ['event/view', 'id' => $model->id, 'url' => Inflector::slug($model->name)]
            ) ?>
        </h3>

        <?= Html::a(
            Html::img(
                Yii::$app->resourceManager->getUrl($model->thumbnail_name),
                ['alt' => $model->name]
            ),
            ['event/view', 'id' => $model->id, 'url' => Inflector::slug($model->name)],
            ['class' => 'thumbnail']
        ) ?>
    </header>
    <p><?= nl2br(StringHelper::truncateWords(Html::encode($model->description), 54)) ?></p>
    <footer>
        <?php if ($model->isPast()) : ?>
            <?= Html::a('View stats',
                ['event/view', 'id' => $model->id, 'url' => Inflector::slug($model->name)],
                ['class' => 'btn btn-info pull-right']
            ) ?>
        <?php else : ?>
            <?= Html::a('Upcoming',
                ['event/view', 'id' => $model->id, 'url' => Inflector::slug($model->name)],
                ['class' => 'btn btn-success pull-right']
            ) ?>
        <?php endif; ?>

        <div class="text-muted">
            <i class="glyphicon glyphicon-fire icon-shared"></i>
            <?= Yii::$app->formatter->asInteger($model->sharing_counter) ?> people shared
        </div>
        <div class="text-muted">
            <i class="glyphicon glyphicon-eye-close icon-awareness"></i>
            <?= Yii::$app->formatter->asInteger($model->awareness_created_counter) ?> direct awareness
        </div>
        <div class="text-muted">
            <i class="glyphicon glyphicon-heart icon-sentiment" title="Sentiment"></i>
            <?= Yii::$app->formatter->asPercent($model->sentiment_confidence) ?>
            <?= Html::encode($model->sentiment) ?>
        </div>
    </footer>
</div>
