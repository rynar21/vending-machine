<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class Slack
{
    public $url;

    public function curlPost($config){
        $url = ArrayHelper::getValue($config, 'url', Yii::$app->slack->url);
        $data = ArrayHelper::getValue($config, 'data');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url); // set URL
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); //Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //Get data from browser
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); //set custom request method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  //To post a file
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //FALSE to stop cURL from verifying the peer's certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //To check the existence of a common name in the SSL peer certificate

        // grab URL and pass it to the browser
        $result = curl_exec($ch);

        // Close cURL session handle || close cURL resource, and free up system resources
        curl_close($ch);
    }






}









?>
