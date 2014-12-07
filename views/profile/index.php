<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\web\View;

/** @var View $this */
$this->title = 'Profile';
?>


<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <img src="http://pbs.twimg.com/profile_images/378800000501279465/ab1cae324a629734dc2dd2e1ef7b9644.jpeg"/>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
        <?php $form = ActiveForm::begin([
            'id' => 'profile',
        ]) ?>
        <?= $form->field($user, 'email')->input('email') ?>
        <?= $form->field($user, 'first_name') ?>
        <?= $form->field($user, 'last_name') ?>
        <?= $form->field($user, 'address') ?>
        <?= $form->field($user, 'country', ['enableLabel' => false])->hiddenInput() ?>
        <?= $form->field($user, 'city', ['enableLabel' => false])->hiddenInput() ?>

        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>

<?php $this->registerJsFile('http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places'); ?>
<?php $this->registerJsFile('/js/libs/jquery.geocomplete.js', ['depends' => ['yii\web\JqueryAsset']]); ?>
<?php $this->registerJsFile('/js/profile.js', ['depends' => ['/js/libs/jquery.geocomplete.js']]); ?>
