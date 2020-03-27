<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class FakerS3
{
    public $credentials;
    public $region;
    public $bucket;
    public $defaultAcl;

    public function upload($key, $data, $acl, $params)
    {
        $result = file_get_contents($data);

        file_put_contents('/app/@cdn/' . $key, $result);
    }

    public function delete($key)
    {
        if (!@unlink($key)) {
            echo "File not found";
        }
    }
}
