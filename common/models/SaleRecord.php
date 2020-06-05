<?php
// SaleRecord交易订单 信息 数据表
// last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sale_record".
 * @property int $id
 * @property int $box_id
 * @property int $item_id
 * @property int $status
 */

class SaleRecord extends \yii\db\ActiveRecord
{
    //public $text;
    // 交易订单 状态

    const STATUS_PENDING = 9;    //购买中
    const STATUS_SUCCESS = 10;   //购买成功
    const STATUS_FAILED  = 8;  //购买失败
    const KEY_SIGNATURE  = 'ojsdjSDASsda213SDMmkxncmcs'; //钥匙

    // 数据表名称
    public static function tableName()
    {
        return 'sale_record';
    }

    // YII 自带时间值 功能
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    // 数据表 属性 规则
    public function rules()
    {
        return [
            [['box_id', 'item_id',], 'required'],
            [['box_id', 'item_id',], 'integer'],
            [['text'], 'string'],
            [['unique_id'],'unique'],
            [['sell_price'], 'number'],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
        ];
    }

    // 数据表 属性 标志
    public function attributeLabels()
    {
        return [
            'transactionNumber' => 'TransactionNumber',
            'store_id' => 'Store ID',
            'box_id' => 'Box ID',
            'item_id' => 'Item ID',
            'status' => 'Status',
            'sell_price' => 'Price',
            'text'=>'SaleRecord_ID',
        ];
    }

   //  public function getStorename()
   // {
   //     if (!empty($this->store->id))
   //     {
   //         return $this->store->name;
   //     }
   // }

    public function getText()
    {
        return $this->box_code.$this->unique_id;
    }

    // 寻找 Item产品 数据表
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->via('item');
    }

    // 寻找 Box盒子 数据表
    public function getBox()
    {
        return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id'])->via('box');
    }

    public function getPricing()
    {
        $num = number_format($this->sell_price, 2);

        return 'RM '.$num;
    }

    //Change Array to String
    public function _toString()
    {
        $arr = [
            'Store Name' => $this->store->name,
            'Address'=> $this->store->address,
            'Transaction ID' => $this->id,
            'Purchased Time' => $this->updated_at,
            'Box' => $this->box->code,
            'Item' => $this->item->name,
        ];

        //对数组中的每个元素应用用户自定义函数
        array_walk($arr,
            function (&$v, $k)
            {
                $v = $k.':'.$v;
            }
        );

        return implode(',', $arr);
    }

    // 更新 对应的数据表里的 属性
    // 交易状态： 购买当中
    public function pending()
    {
        if ($this->status != SaleRecord::STATUS_SUCCESS && $this->status != SaleRecord::STATUS_FAILED)
        {
           // 更新 Item产品 的状态属性 为购买当中
           $this->status = SaleRecord::STATUS_PENDING;
           $this->save();
           $this->item->status = Item::STATUS_LOCKED;
           $this->item->save();
        }

        return $this->save() && $this->item->save();
    }

    // 交易状态：购买成功
    public function success()
    {
        if ($this->status == SaleRecord::STATUS_PENDING)
        {
            // 更新 Item产品 的状态属性 为购买成功
            $this->status = SaleRecord::STATUS_SUCCESS;
            $this->save();
            // 更新 Item产品 的状态属性 为购买成功
            $this->item->status = Item::STATUS_SOLD;
            $this->item->save();
            // 更新 Box盒子 的状态属性 为空
            $this->box->status = Box::BOX_STATUS_NOT_AVAILABLE;
            $this->box->save();

            Queue::push($this->store_id, $this->box->hardware_id);
         }
    }

    // 交易状态： 购买失败
    public function failed()
    {
        if ($this->status != SaleRecord::STATUS_SUCCESS)
        {
            $this->status = SaleRecord::STATUS_FAILED;
            $this->save();

            $this->item->status = Item::STATUS_AVAILABLE;
            $this->item->save();
        }
    }

    public function getNet_profit($id)
    {
        $p_id    = Item::find()->where(['store_id' => $id])->one()->product_id;
        $model   = Product ::find()->where(['id' => $p_id])->one();

        if (!empty($model->cost))
        {
            $cost_price = $model->cost;

            return $cost_price;
        }

    }

    public function executeUpdateStatus()
    {
        if ($this->getIsFinalStatus()) {
            return false;
        }
        return $this->querySpOrderAPI();
    }

    private function getIsFinalStatus()
    {
        if ($this->status == self::STATUS_PENDING) {
            return false;
        }
        return true;
    }

    private function querySpOrderAPI()
    {
        // $response_data = Yii::$app->spay->checkOrder([
        //     'merOrderNo' => $this->order_number,
        // ])

        $data = [
            'merchantId' => Yii::$app->spay->merchantId,
            'merOrderNo' => $this->order_number,
        ];

        $response_data = Yii::$app->spay->checkOrder($data);

        $array         = json_decode($response_data);
        $orderStatus   = $array->{'orderStatus'};

        if ($this->getIsFinalStatus()) {
            return false;
        }

        if (Yii::$app->spay->getIsFinalStatus($orderStatus))
        {
            return false;
        }

        if (Yii::$app->spay->getIsPaymentSuccess($orderStatus))
        {
            return $this->success();
        }

        return $this->failed();
    }

    public  function queryPendingOrder()
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

    private  function testAPI($count_array, $count_number, $data)
    {

        Yii::$app->slack->Posturl([
            'url' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=11057651-b2bf-42a9-9eb3-760049e1ac87',
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

}
