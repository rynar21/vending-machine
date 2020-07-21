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

        // $this->testAPI();

        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }

    public function queryPendingOrder()
    {
        $count_number = 0;
        $data = [];
        $records = SaleRecord::find()->where([
            'status' => SaleRecord::STATUS_PENDING,
        ])->all();

        if ($records)
        {
            foreach ($records as $record)
            {
                if ($record->executeUpdateStatus()) {
                    $count_number += 0;
                }

                $count_number += 1;

                if ($record->status == SaleRecord::STATUS_PENDING)
                {
                    $count_number = $count_number - 1;
                }

                if ($record->status == SaleRecord::STATUS_SUCCESS)
                {
                    $data[] = $record->order_number . ' Success';
                }

                if ($record->status == SaleRecord::STATUS_FAILED)
                {
                    $data[] = $record->order_number . ' Failed';
                }

            }
        }

        return $this->testAPI(count($records), $count_number, $data);
    }



    private  function testAPI($count_array, $count_number, $data)//vm -测试机器人
    {
        if (($count_number) > 0)
        {
            Yii::$app->slack->Posturl([
                'url' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=e7ac265a-747d-4eb0-9706-9957c18c8200',
                'data' => [
                        "msgtype" => "text",

                        "text" => [
                            "content" => "查询支付中订单:".$count_array."条"."\n".
                            "处理:".$count_number."条"."\n".
                            "OrderNumber:".'    '."Status:"."\n". implode("\n", $data),
                        ],
                ],
            ]);


        }

        return $this->testStockManage($count_array, $count_number, $data);
    }

    private  function testStockManage($count_array, $count_number, $data)
    {
            Yii::$app->slack->Posturl([
                'url' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=fd873fcf-db44-4e7e-b1cb-b7bfad02401b',
                'data' => [
                        "msgtype" => "text",

                        "text" => [
                            "content" => "查询支付中订单:".$count_array."条"."\n".
                            "处理:".$count_number."条"."\n".
                            "OrderNumber:".'    '."Status:"."\n". implode("\n", $data),
                        ],
                ],
            ]);

        return false;
    }

}

























?>
