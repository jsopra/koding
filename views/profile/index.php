<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\web\View;

/**
 * @var View $this
 * @var \app\models\forms\ProfileForm $model
 * @var \yii\authclient\Collection $collection
 */

$this->title = 'Profile';

$collection = Yii::$app->authClientCollection;
$facebook = $collection->getClient('facebook');
$twitter = $collection->getClient('twitter');

$authChoice = new \yii\authclient\widgets\AuthChoice();
$authChoice->setBaseAuthUrl(['profile/connect']);

$picture = $model->user->photo ?: Yii::$app->request->baseUrl . '/img/anonymous-user.png';
?>

<div class="bs-callout bs-callout-info">
    Connect your other social accounts so you can share everywhere.
</div>

<div class="social-wrap align-center">
    <?php foreach (['twitter', 'facebook'] as $social) : ?>
        <?php if ($model->user->$social) : ?>
            <a class="button <?= $social ?> disabled" href="javascript:;">Connected</a>
        <?php else : ?>
            <?php $authChoice->clientLink($$social, 'Connect ' . ucfirst($social), ['class' => 'button ' . $social]) ?>
        <?php endif ?>
    <?php endforeach; ?>
</div>

<hr>

<div class="row">
    <div class="col-md-11 col-md-offset-1">
        <h2>Hey <?= ucwords(Html::encode($model->user->first_name)) ?>, check if this data is correct</h2>
    </div>
</div>

<div class="row user-profile">
    <div class="col-md-2 col-md-offset-1">
        <img class="photo" src="<?= $picture ?>" width="150" height="150" />
    </div>
    <div class="col-md-4">
        <?php $form = ActiveForm::begin([
                'id' => 'profile',
                'options' => [
                    'class' => 'form-horizontal'
                ]
            ]) ?>

        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'last_name') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'country', ['enableLabel' => false])->hiddenInput() ?>
        <?= $form->field($model, 'city', ['enableLabel' => false])->hiddenInput() ?>

        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>


<?php $this->registerJsFile('http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places'); ?>
<?php $this->registerJsFile('/js/libs/jquery.geocomplete.js', ['depends' => ['yii\web\JqueryAsset']]); ?>
<?php $this->registerJsFile('/js/profile.js', ['depends' => ['/js/libs/jquery.geocomplete.js']]); ?>
