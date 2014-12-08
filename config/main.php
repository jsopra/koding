<?php
/**
 * Main config for both Web and Console applications (console-main.php and web-main.php)
 */

$params = require(__DIR__ . '/params.php');

$config = [
    'charset' => 'UTF-8',
    'params' => $params,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'Social Warming',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        'urlShortener' => [
            'class' => 'app\components\UrlShortener',
            'token' => getenv('SW_BITLY_TOKEN'),
        ],
        /**
         * Database connection
         */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('SW_DB_DSN'),
            'username' => getenv('SW_DB_USERNAME'),
            'password' => getenv('SW_DB_PASSWORD'),
            'charset' => 'utf8',
            'enableSchemaCache' => false, // development
        ],
        /**
         * UrlManager
         */
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'privacy-policy' => 'site/privacy-policy',
                'event/<id:\d+>-<url>/<action:update|delete|join|unjoin>' => 'event/<action>',
                'event/<id:\d+>/<action:update|delete|join|unjoin>' => 'event/<action>',
                'event/<id:\d+>-<url>' => 'event/view',
                'event/<id:\d+>' => 'event/view',
            ],
        ],
        /**
         * Mailer
         *
         * @link https://github.com/yiisoft/yii2-swiftmailer
         * @link http://swiftmailer.org/docs/messages.html
         */
        'mailer' => [
            'messageConfig' => [
                'charset' => 'utf-8',
                'from' => [$params['supportEmail'] => $params['supportName']],
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',
                'username' => 'contact@monitorbacklinks.koding.io',
                'port' => '25',
            ],
        ],
        /**
         * Caching
         */
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /**
         * Logging
         */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'debug' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['debug'],
                    'logFile' => '@runtime/logs/debug.log',
                    'logVars' => [],
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV || YII_ENV_TEST) {
    unset($config['components']['mailer']['transport']);
    $config['components']['mailer']['useFileTransport'] = true;
}

return $config;
