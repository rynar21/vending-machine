<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;



class Plugin
{

    function get_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);  //设置访问的url地址
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
        $result =  curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

}
