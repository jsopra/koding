<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2>Almost done ... </h2>
        <div>
            <?php $form = ActiveForm::begin([
                    'id' => 'signup-completion',
                ]) ?>
            <?= $form->field($user, 'email')->input('email') ?>
            <?= $form->field($user, 'first_name')->input('text') ?>
            <?= $form->field($user, 'last_name')->input('text') ?>

            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

