<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach (array_chunk($dataProvider->getModels(), 3) as $events) : ?>
        <div class="row events-list">
            <?php foreach ($events as $event) : ?>
                <?= $this->render('/event/_view', ['model' => $event]) ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination
    ]) ?>

</div>
