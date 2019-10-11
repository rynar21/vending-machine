<?php
return [
   'timeZone' => 'Asia/Singapore',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        // 'urlManager' => [
        //      'enablePrettyUrl' => true,
        //      'showScriptName' => false,//隐藏index.php
        //      //'enableStrictParsing' => false,
        //      'suffix' => '15Esd5191Sdfsdsds855EnJADNDLnlkNsuiS546sJS',//后缀，如果设置了此项，那么浏览器地址栏就必须带上.html后缀，否则会报404错误             'rules' => [
        //          //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        //      ],
    ],


    
];
