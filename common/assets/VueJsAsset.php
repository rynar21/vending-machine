<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class VueJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        // '//cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js',
        'https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js',
        // '//cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js',
        // '//cdnjs.cloudflare.com/ajax/libs/vuejs-datepicker/1.6.2/vuejs-datepicker.js',
        // '//unpkg.com/vuejs-datepicker',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
