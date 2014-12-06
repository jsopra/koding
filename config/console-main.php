<?php
/**
 * Main config for console application
 */

return [
    'controllerNamespace' => 'app\console',
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        /**
         * User
         */
        'user' => [
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
