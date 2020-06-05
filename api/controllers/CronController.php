<?php
namespace api\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use common\models\SaleRecord;
use yii\rest\Controller;


/**
 * Site controller
 */
class CronController extends Controller
{

    public function actionMinute()
    {
        $this->queryPendingOrder();

        $this->testAPI();

        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }

    private function queryPendingOrder()
    {
        $SaleRecord = new SaleRecord();
        $SaleRecord->queryPendingOrder();
    }

    private function testAPI()
    {
        $ip = gethostbyname(gethostname()); //主机IP
        Yii::$app->slack->Posturl([
            'url' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=216b4e9e-8404-457c-8996-fd171fa3224f',
            'data' => [
                    "msgtype" => "text",

                    "text" => [
                        "content" => date('Y-m-d H:i:s', time()). ' '."IP:".$ip,
                    ],
            ],
        ]);
    }







}

























?>
