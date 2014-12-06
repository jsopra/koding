<?php
/**
 * Yii web bootstrap file.
 */

/**
 * Detect Development or Production server
 */
if (getenv('SW_ENVIRONMENT') == 'development') {
    defined('YII_ENV') or define('YII_ENV', 'dev');
    defined('YII_DEBUG') or define('YII_DEBUG', true);
}
/**
 * Include Core files
 */
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');
/**
 * Merge configs
 */
$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/web.php')
);
/**
 * Initialize application
 */
$application = new yii\web\Application($config);
$application->run();
