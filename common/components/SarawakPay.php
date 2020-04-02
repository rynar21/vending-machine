<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\plugins\spayplugins\plugins\SarawakPay as SP_Plugin;

class SarawakPay
{
    public $merchantId;
    public $url;

    public function post($api, $data)
    {
        SP_Plugin::post($api, $data);
    }

    public function createOrder($data)
    {
        $data   = json_encode($data, 320);
        return  SP_Plugin::post($this->url. "H5PaymentAction.preOrder.do", $data);
    }

    public function checkOrder($data)
    {
        $data   = json_encode($data, 320);
        return  SP_Plugin::post($this->url. "H5PaymentAction.queryOrder.do", $data);
    }
}
