<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\plugins\spayplugins\plugins\spay\SarawakPay as SP_Plugin;

class SarawakPay
{
    public $merchantId;
    public $url;

    public function post($api, $data)
    {
        SP_Plugin::post($this->url . $api, $data);
    }

    public function createOrder($data)
    {
        $data['merchantID'] = $this->merchantId;
        return SP_Plugin::post($this->url . 'H5Payment.preOrder.do', $data);
    }
}
