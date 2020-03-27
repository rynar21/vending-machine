<?php
return [
    'aliases' => [
        '@upload'       => '/app/backend/web/mel-img/',
        '@imagePath'    => 'http://localhost:21110/products',
        '@url'         => 'C:\Users\user\Desktop\up',
        '@static'       => 'http://localhost:21110/',
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];
