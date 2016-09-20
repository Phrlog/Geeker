<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GeekerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/bootstrap-material-design.css',
        'css/ripples.min.css',
        'css/material-scrolltop.css',
        'css/material-blog.css',
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
        'https://fonts.googleapis.com/icon?family=Material+Icons'
    ];
    public $js = [
        'js/pace.min.js',
        'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js',
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
        'js/jquery-1.11.3.min.js',
        'js/ripples.min.js',
        'js/material.min.js',
        'js/material-scrolltop.js',
        'js/main.js',
        'js/init.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
