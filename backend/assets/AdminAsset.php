<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        /* bootstrap */
        'css/bootstrap/bootstrap.min.css',

        /* libraries */
        'css/libs/font-awesome.css',
        'css/libs/nanoscroller.css',

        /* global styles */
        'css/compiled/theme_styles.css',

        /* specific page */
        'css/libs/daterangepicker.css',
        'css/libs/jquery-jvectormap-1.2.2.css',
        'css/libs/weather-icons.css',

        /* google font */
        '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300'
    ];
    public $js = [

        /* RTL support */
        'js/demo-rtl.js',

        /* global scripts */
        'js/demo-skin-changer.js',
        'js/jquery.js',
        'js/jquery.nanoscroller.min.js',
        'js/demo.js',

        /* specific scripts */
        'js/moment.min.js',
        'js/jquery-jvectormap-1.2.2.min.js',
        'js/jquery-jvectormap-world-merc-en.js',
        'js/gdp-data.js',
        'js/flot/jquery.flot.min.js',
        'js/flot/jquery.flot.resize.min.js',
        'js/flot/jquery.flot.time.min.js',
        'js/flot/jquery.flot.threshold.js',
        'js/flot/jquery.flot.axislabels.js',
        'js/jquery.sparkline.min.js',
        'js/skycons.js',

        /* theme script */
        'js/scripts.js',
        'js/pace.min.js',

        /* init */
        'init.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
