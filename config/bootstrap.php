<?php
/**
 * Use this file to
 * - define aliases
 * - extend helper classes
 * - overriding defaults via DI
 * @link https://github.com/yiisoft/yii2/commit/5190fbfe37bfedf3bf46bc645908af8226cfa6ff#commitcomment-7761047
 */

/**
 * Define aliases
 */
Yii::setAlias('web', '/');
Yii::setAlias('webroot', dirname(__DIR__));
Yii::setAlias('console', dirname(__DIR__) . '/console');
Yii::setAlias('runtime', dirname(__DIR__) . '/runtime');
