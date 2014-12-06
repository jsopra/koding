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
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        /**
         * UrlManager
         */
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
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

return $config;
