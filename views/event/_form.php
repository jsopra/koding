<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'hashtag')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group field-event-occurred_on required">
        <?= Html::activeLabel($model, 'occurred_on') ?>
        <?= DatePicker::widget([
            'model' => $model,
            'attribute' => 'occurred_on',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
        ]) ?>
        <?= Html::error($model, 'occurred_on') ?>
    </div>

    <?php if ($model->image_name) : ?>
    <div><?= Html::img(Yii::$app->resourceManager->getUrl($model->image_name), ['alt' => 'Event image']) ?></div>
    <?php endif; ?>

    <?= $form->field($model, 'image_file')->fileInput() ?>

    <?php if ($model->thumbnail_name) : ?>
    <div><?= Html::img(Yii::$app->resourceManager->getUrl($model->thumbnail_name), ['alt' => 'Event thumbnail']) ?></div>
    <?php endif; ?>

    <?= $form->field($model, 'thumbnail_file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
