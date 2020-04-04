<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;

use common\plugins\spay\SarawakPay as SP_Plugin;

class SarawakPay
{
    public $merchantId;
    public $url;

    public $privateKeyPath;
    public $publicKeyPath;
    public $sarawakPayPublicKeyPath;

    public function createOrder($data)
    {
        return $this->post('H5PaymentAction.preOrder.do', $data);
    }

    public function checkOrder($data)
    {
        return $this->post('H5PaymentAction.queryOrder.do', $data);
    }

    private function post(string $api, array $data)
    {
        $data['merchantId'] = $this->merchantId; // injecting merchantID into data
        $jsonData           = Json::encode($data);

        return SP_Plugin::post($this->url . $api, $jsonData, Yii::getAlias($this->sarawakPayPublicKeyPath), Yii::getAlias($this->privateKeyPath));
    }

    public function decrypt(string $encryptedData)
    {
        return SP_Plugin::decrypt($encryptedData, Yii::getAlias($this->privateKeyPath));
    }
}
