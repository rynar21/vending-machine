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

    public function actionRequest()
    {
        $this->queryPendingOrder();

        // $this->testAPI();

        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }

    private function queryPendingOrder()
    {
        $records = SaleRecord::find()->where([
                'status' => SaleRecord::STATUS_PENDING,
        ])->all();

        if ($records)
        {
            foreach ($records as $record)
            {
                $this->querySpOrderAPI($record->order_number);
            }
        }

    }

    private function querySpOrderAPI($order_number)
    {
        $data = [
            'merchantId' => Yii::$app->spay->merchantId,
            'merOrderNo' => $order_number,
        ];

        $response_data = Yii::$app->spay->checkOrder($data);
        $array         = json_decode($response_data);
        $orderStatus   = $array->{'orderStatus'};

        $this->checkOrderStatus($order_number,$orderStatus);
    }

    private function checkOrderStatus($order_number,$orderStatus)
    {
        $record = SaleRecord::findOne(['order_number' => $order_number]);

        if ($orderStatus == 1)
        {
            $record->success();
        }

        if ($orderStatus == 4)
        {
            $record->failed();
        }
    }

    private function testAPI()
    {
        $ip = Yii::$app->request->userIP; //主机IP
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
