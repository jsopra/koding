<?php
/**
 * Main Shared config for web application
 */

$config = [
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        /**
         * Request
         */
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'cookieValidationKey' => 'KtG9T4x2rRMDA7Jtguswcw5jY7ZdDZ',
        ],
        /**
         * User
         */
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['login'],
            'enableAutoLogin' => true,
        ],
    ],
];

return $config;
