<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [

        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
            'application/json' => 'yii\web\JsonParser',
            'text/json' => 'yii\web\JsonParser',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
            'defaultRoles' => ['default'],
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'authTimeout'     => 6000,
            'identityCookie' => ['name' => '_identity-backend','httpOnly' => true],
        ],

        // 'slack' =>[
        //     'class'=>'common\commontans\Slack',
        //     'url'=>'https://hooks.slack.com/services/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',
        // ]
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 60,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            'maxSourceLines' => 80,

        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
              'operator/something' => 'operator/create',
            ],
        ],
    ],
    'params' => $params,
];
