<?php
/**
 * Development config for web application
 */

return [
    'id' => 'hackathon-dev-web',
    'bootstrap' => ['gii', 'debug'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', $_SERVER['REMOTE_ADDR']],
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', $_SERVER['REMOTE_ADDR']],
        ],
    ],
];
