<?php
/**
 * Main config for console application
 */

return [
    'id' => 'hackathon-' . YII_ENV . '-console',
    'controllerNamespace' => 'app\console',
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        /**
         * User
         * TODO: Extend component to ConsoleUser
         */
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableSession' => false,
        ],
        /**
         * Url Manager
         */
        'urlManager' => [
            'baseUrl' => 'http://monitorbacklinks.koding.io',
            'hostInfo' => 'http://monitorbacklinks.koding.io',
        ],
    ],
];
