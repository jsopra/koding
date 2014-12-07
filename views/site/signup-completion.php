<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
]) ?>
<?= $form->field($user, 'email')->input('email') ?>
<?= $form->field($user, 'first_name')->input('text') ?>
<?= $form->field($user, 'last_name')->input('text') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>