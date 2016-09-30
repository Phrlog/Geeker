<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/site.css',
        /* Bootstrap core CSS and Material Bootstrap */
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/bootstrap-material-design.css',
        'css/ripples.min.css',
        'css/material-scrolltop.css',

        /*  Custom styles for this template */
        'css/material-blog.css',

        /* Fonts */
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
        'https://fonts.googleapis.com/icon?family=Material+Icons'
    ];
    public $js = [

        /* Loading animation  */
        'js/pace.min.js',

        /* libraries */
        'js/jquery-1.11.3.min.js',
        'js/ripples.min.js',
        'js/material.min.js',
        'js/material-scrolltop.js',
        'js/main.js',
        'js/affix.js',
        'js/init.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
