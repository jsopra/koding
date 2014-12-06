<?php
/**
 * Main (shared) production config for both console and web applications
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
            'password' => 'dj2swzJGCnNrZJxb',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
        ],
    ],
];
