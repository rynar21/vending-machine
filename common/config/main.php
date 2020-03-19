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
        //     'urlManager' => [
        //     'enablePrettyUrl' => true,
        //     'showScriptName' => false,
        //     'enableStrictParsing' => false,
        //     //'suffix' => '.html',  // 伪后缀
        //     'rules'=>[
        //            'vending-machine' =>'vending-machine/backend',
        //            '<controller>' => '<controller>/index',
        //     	   '<controller:[\w+]+>.<action>/<id:\d+>.html' => '<controller>/<action>',
        //            //'sale-record.<id:\d+>.html' => 'sale-record/<action>',
        //             "<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
        //     ],
        // ],
        'slack' =>[
            'class'=>'common\commontans\Slack',
            'url'=>'https://hooks.slack.com/services/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',
        ],
        // 'request' => [
        //     'enableCsrfValidation' => false,
        // ],
    ],



];
