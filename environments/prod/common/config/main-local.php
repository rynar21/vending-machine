<?php
return [
    'aliases' => [
        '@upload'       => '/app/backend/web/mel-img/',
        '@imagePath'    => 'http://localhost:21080/mel-img',
        '@url'         => 'C:\Users\user\Desktop\up',
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];
