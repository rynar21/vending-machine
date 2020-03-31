<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '/app/cdn';
    public $baseUrl = '@static';

    public $css = [
        'css/site.css',
        'https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css',
    ];
    public $js = [
        'https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
