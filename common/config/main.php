<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => false,
            // Use pretty URLs
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
                '/' => 'geeks/index',
                'logout' => 'site/logout',
                'login' => 'site/login',
                'about' => 'site/about',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ]
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'http://geek.brains',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'geeks/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/edit',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ]
    ],
    'defaultRoute' => 'site'
];
