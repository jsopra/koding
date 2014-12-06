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
        <p><span>9,933</span> People joined this event</p>
        <p><span>3,335,3111</span> Awareness created</p>
    </footer>

</div>