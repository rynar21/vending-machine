<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class Signature
{
    public function generateSignature($config)
    {
        $data = ArrayHelper::getValue($config, 'data','');
        $signature='s.OPa4c%j!F%P@8~1+D[,2Rl|%?Klmbh';
        $generate_signature=hash_hmac('sha256',$data,$signature);
        return $generate_signature;
        // return Yii::$app->slack->send([
        //     'data'=>$generate_signature,
        //     'url'=>'https://pcl.requestcatcher.com',
        // ]);
    }
}
