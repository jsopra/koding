<?php

/** @var \yii\authclient\Collection $collection */
$collection = Yii::$app->authClientCollection;

$facebook = $collection->getClient('facebook');
$twitter = $collection->getClient('twitter');

$user = Yii::$app->user->identity;

$authChoice = new \yii\authclient\widgets\AuthChoice();
$authChoice->setBaseAuthUrl(['profile/connect']);
?>

<?php foreach (['twitter', 'facebook'] as $social) : ?>
    <?php if ($user->$social) : ?>
        <a class="btn btn-primary disabled" href="javascript:;">Connected to <?= ucfirst($social) ?></a>
    <?php else : ?>
        <?php $authChoice->clientLink($$social, 'Connect to ' . ucfirst($social), ['class' => 'btn btn-primary']) ?>
    <?php endif ?>
<?php endforeach; ?>
