<?php

namespace common\assets;

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
        'css/card.css',
        'css/grid.css',
        'css/nav.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
