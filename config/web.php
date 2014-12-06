<?php
/**
 * Main Shared config for web application
 */

$config = [
    'id' => 'hackathon-' . YII_ENV . '-web',
    /**
     * APPLICATION COMPONENTS
     */
    'components' => [
        /**
         * AuthClient
         */
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => getenv('SW_TWITTER_CONSUMER_KEY'),
                    'consumerSecret' => getenv('SW_TWITTER_CONSUMER_SECRET'),
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => getenv('SW_FACEBOOK_CLIENT_ID'),
                    'clientSecret' => getenv('SW_FACEBOOK_CLIENT_SECRET'),
                ],
            ],
        ],
        /**
         * Request
         */
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'cookieValidationKey' => getenv('SW_COOKIE_VALIDATION_KEY'),
        ],
        /**
         * User
         */
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['login'],
            'enableAutoLogin' => true,
        ],
        /**
         * Handle errors with specific Action
         */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
];

/**
 * If environment is development, add debug and gii modules
 */
if (YII_ENV_DEV) {
    $config = yii\helpers\ArrayHelper::merge(
        $config,
        [
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
        ]
    );
}

return $config;
