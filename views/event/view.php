<?php

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <header>
        <h1><?= Html::encode($this->title) ?></h1>
        <h2><?= Html::encode($model->hashtag) ?></h2>
        <p>
            <time datetime="<?= $model->occurred_on ?>">
                <?= Yii::$app->formatter->asDate($model->occurred_on) ?>
            </time>
        </p>
    </header>
    <p><?= nl2br(Html::encode($model->description)) ?></p>
    <footer>
        <p>
            <span><?= Yii::$app->formatter->asInteger($model->joined_users_counter) ?></span>
            People joined this event
        </p>
        <p>
            <span><?= Yii::$app->formatter->asInteger($model->awareness_created_counter) ?></span>
            Awareness created
        </p>
    </footer>

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

    <?php if ($recentJoinings) : ?>
    <section>
        <h2>People who joined</h2>
        <ul>
            <?php foreach ($recentJoinings as $recentJoin) : ?>
            <li>
                <?= $recentJoin->user->username ?>
                <time datetime="<?= $recentJoin->joined_at ?>">
                    <?= Yii::$app->formatter->asRelativeTime($recentJoin->joined_at) ?>
                </time>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

</div>