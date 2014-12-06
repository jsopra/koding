<?php

use yii\helpers\Html;
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
        <h2>#<?= Html::encode($model->hashtag) ?></h2>
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