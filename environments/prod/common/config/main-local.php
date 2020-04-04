<?php
return [
    'aliases' => [
        '@upload'       => '/app/backend/web/mel-img/',
        '@imagePath'    => 'http://localhost:21110/products',
        '@urlBackend'   => 'http://vm-admin.payandgo.link/',
        '@urlFrontend'  => 'http://vm.payandgo.link/',
        '@static'       => 'https://s3-ap-southeast-1.amazonaws.com/cdn.payandgo.link/',
    ],
    'components' => [
        'spay' => [
            'class'                     => 'common\components\SarawakPay',
            'merchantId'                => 'M100001040',
            'url'                       => 'https://spfintech.sains.com.my/xservice/',
            'privateKeyPath'            => '@common/plugins/spay/merchant_private_key.key',
            'publicKeyPath'             => '@common/plugins/spay/merchant_public_key.key',
            'sarawakPayPublicKeyPath'   => '@common/plugins/spay/sarawakpay_public_key.pem',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        [
                            '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
                            'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa',
                            'crossorigin' => 'anonymous',
                        ],
                    ],
                ],
                'common\assets\AppAsset' => [
                    'css' => [
                        '//s3-ap-southeast-1.amazonaws.com/cdn.payandgo.link/css/site.css',
                    ],
                ],
            ],
        ],
    ],
];
