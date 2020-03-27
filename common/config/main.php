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
        'db' => [
            'class'     => 'yii\db\Connection',
            'dsn'       => 'mysql:host=' . getenv('RDS_HOSTNAME') . ':' . getenv('RDS_PORT') . ';dbname='  . getenv('RDS_DB_NAME'),
            'username'  => getenv('RDS_USERNAME'),
            'password'  => getenv('RDS_PASSWORD'),
            'charset'   => 'utf8mb4',
        ],
        'slack' =>[
            'class'=>'common\commontans\Slack',
            'url'=>'https://hooks.slack.com/services/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',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\SyslogTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];
