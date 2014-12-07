<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <h2>Technologies and Code Quality</h2>
    <div class="well well-sm">
        <a href="https://github.com/monitorbacklinks/koding/blob/master/README.md" target="_blank">
            https://github.com/monitorbacklinks/koding/blob/master/README.md
        </a>
    </div>
</div>
