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

        /* theme script */
        'js/scripts.js',
        'js/pace.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
