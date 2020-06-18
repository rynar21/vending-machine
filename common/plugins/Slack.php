<?php

namespace common\plugins;

use Yii;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\SaleRecord;

class Slack
{
    public $url;

    //发送加密信息给iot
    public function Skey($array)
    {
        $a="sha256";
        $key=100;
        $url = ArrayHelper::getValue($array, 'url', Yii::$app->slack->url);
        $price=ArrayHelper::getValue($array,'price','null');
        $id=ArrayHelper::getValue($array,'id','null');
        // $price=hash_hmac ($a,$price,$key [$raw_output=FALSE]);
        // $id=hash_hmac ($a,$id,$key [$raw_output=FALSE]);
        $keys=hash_hmac($a,$price.$id.SaleRecord::KEY_SIGNATURE,$key[$raw_output=FALSE]);
        Yii::$app->slack->Posturl([
            'url'=>$url,
            'data'=>[
                    "iotprice"=>$price,
                    "salerecord_id"=>$id,
                    'key'=>$keys,
            ],
        ]);
    }

    public function postUrl($array)
    {
            $url = ArrayHelper::getValue($array, 'url', Yii::$app->slack->url);
            $data=ArrayHelper::getValue($array,'data','Hello World!');
            //$getdata=$this->gData($data);
            $data  = json_encode($data);
            $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");//设置格式
            $curl = curl_init();//初始化CURL句柄
            curl_setopt($curl, CURLOPT_URL, $url);//设置请求的URL
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);//针对主机验证证书的名称
            curl_setopt($curl, CURLOPT_POST, 1);//如果你想PHP去做一个正规的HTTP POST，设置这个选项为一个非零值。
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//传递一个作为HTTP “POST”操作的所有数据的字符串。
            curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);//设置自定义HTTP标头
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//讲curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
            $output = curl_exec($curl); //执行一个cURL会话
            curl_close($curl);//关闭一个cURL会话
            return json_decode($output,true);
    }

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

    //一维数组键值分离......并转换为字符串
    public function eopLo($data)
    {
        $kunum =(array_keys($data));//取键
        $sk = (array_values($data));//取值
        for ($i=0; $i <=count($kunum)-1; $i++)//组成一个二维数组
        {
            $d[]=array($kunum[$i],$sk[$i]);
        }
        foreach ($d as $val)//取每个数组的val值 组成一个一维数组
        {
            $val = join(":",$val);
            $temp_array[] = $val;
        }
        $e=implode(",",$temp_array);//数组转换为字符串
        return $e;
    }
    public function gData($data)
    {
        if(is_array($data))
        {
            $e=$this->eopLo($data);//键值分离，转换为字符串
            return $a=["text"=>$e];
        }
        if(!is_array($data))
        {
            return $a=["text"=>$data];
        }
    }
}
