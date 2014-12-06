<?php
/**
 * Main (shared) development config for both console and web applications
 */

return [
    'components' => [
        /**
         * Database connection
         */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=koding',
            'username' => 'koding',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => false, // development
        ],
        /**
         * Mailer
         *
         * @link https://github.com/yiisoft/yii2-swiftmailer
         * @link http://swiftmailer.org/docs/messages.html
         *
         * Set email password manually and disable File Transport if you need to test email template first time at:
         * @link http://www.mail-tester.com/
         */
        'mailer' => [
            'useFileTransport' => true, // Saves email in /runtime/debug/mail instead of sending it
        ],
    ],
];
