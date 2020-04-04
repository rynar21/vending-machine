<?php
return [
    'aliases' => [
        '@upload'       => '/app/backend/web/mel-img/',
        '@imagePath'    => 'http://localhost:21110/products',
        '@urlBackend'   => 'http://localhost:21080/',
        '@urlFrontend'  => 'http://localhost:20080/',
        '@static'       => 'http://localhost:21110/',
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        's3' => [
            'class' => '\common\components\FakerS3',
        ],
        'spay' => [
            'class'                     => 'common\components\SarawakPay',
            'merchantId'                => 'M100001040',
            'url'                       => 'https://spfintech.sains.com.my/xservice/',
            'privateKeyPath'            => '@common/plugins/spay/merchant_private_key.key',
            'publicKeyPath'             => '@common/plugins/spay/merchant_public_key.key',
            'sarawakPayPublicKeyPath'   => '@common/plugins/spay/sarawakpay_public_key.pem',
        ],
        'assetManager' => [
            // For live site cdn assets
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'http://localhost:21110/cdn/jquery/2.2.4/jquery.min.js',
                        // 'crossorigin' => 'anonymous',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'http://localhost:21110/cdn/bootstrap/3.3.7/css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        [
                            'http://localhost:21110/cdn/bootstrap/3.3.7/js/bootstrap.min.js',
                        ],
                    ],
                ],
                'common\assets\FontAwesomeAsset' => [
                    'css' => [
                        'http://localhost:21110/cdn/fontawesome/v5.6.3/css/all.css',
                    ],
                ],
            ],
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'scss' => ['css', '/usr/local/bin/sass {from} {to} --style compressed'],
                ],
            ],
        ],
    ],
];
