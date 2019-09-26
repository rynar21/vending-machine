<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class Slack
{
    public $url;

    public function send($config)
    {
        $url = ArrayHelper::getValue($config, 'url', Yii::$app->slack->url);
        $data = ArrayHelper::getValue($config, 'data', ['text'=>'Hello, World!']);
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//设置提交的字符串
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        //1 检查服务器SSL证书中是否存在一个公用名(common name).公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。2 检查公用名是否存在，并且是否与提供的主机名匹配。
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }
}
