<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string the Web-accessible directory that contains the asset files in this bundle.
     */
    public $basePath = '@webroot';
    /**
     * @var string the base URL that will be prefixed to the asset files for them to be accessed via Web server.
     */
    public $baseUrl = '@web';
    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        'css/site.css',
    ];
    /**
     * @var array list of JavaScript files that this bundle contains.
     */
    public $js = [
        'js/highcharts-mapdata-custom-world.js',
    ];
    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
