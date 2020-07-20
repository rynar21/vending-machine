<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;


class PayAndGo
{
        const STATUS_SUCCESS  = 1;    //购买成功
        const STATUS_PENDING  = 0;   //购买中
        const STATUS_INIT     = 10; //初始状态
        const STATUS_FAILED   = 2;
        const STATUS_CANCELED = 3;

        public function checkOrder($order_id)
        {
            return $this->get('api.payandgo.link/payment/view', $order_id);
        }

        private function get(string $api, $order_id)
        {

            return $this->get_url($this->url.$api.'?order_id='.$order_id);

        }

        private function get_url($url)
        {
            return Yii::$app->plugin->get_url($url);
        }

        public function getIsPaymentSuccess($orderStatus)
        {
            if ($orderStatus == self::STATUS_SUCCESS)
            {
                return true;
            }

            return false;
        }

        public function getIsFinalStatus($orderStatus)
        {
            if ($orderStatus == self::STATUS_PENDING)
            {
                return false;
            }
<<<<<<< Updated upstream
=======
            if ($orderStatus == self::STATUS_INIT) {

                return false;
            }
>>>>>>> Stashed changes

            return true;
        }

        public function getIsInitStatus($orderStatus)
        {
            if ($orderStatus == self::STATUS_INIT)
            {
                return true;
            }

            return false;
        }

        public function getIsPaymentFailed($orderStatus)
        {
            if ($orderStatus == self::STATUS_FAILED)
            {
                return true;
            }

            if ($orderStatus == self::STATUS_CANCELED)
            {
                return true;
            }

            return false;
        }

        public function getIsPaymentPending($orderStatus)
        {
            if ($orderStatus == self::STATUS_PENDING)
            {
                return true;
            }
            
            return false;
        }



}
