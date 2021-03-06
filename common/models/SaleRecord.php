<?php
// SaleRecord交易订单 信息 数据表
// last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\models\Product;

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
    const STATUS_INIT = 0; //初始
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
            TimestampBehavior::class,
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
            'unique_id' => 'Reference No.',
        ];
    }

    public function getBoxCode()
    {
        return $this->store->prefix.$this->box->code;
    }

    public function getStores()
    {   
        $models = self::find()->all();

        $data[''] = 'All';
        foreach ($models as $model) {
            $data[$model->store_id] = $model->store->name;
              
        }

        return $data;
    }

    public function getItems()
    {   
        $models = Product::find()->all();

        $data[''] = 'All';
        foreach ($models as $model) {
            $data[$model->id] = $model->name;
              
        }

        return $data;
    }

    public function getStatuses()
    {
        return [
            ''  => 'All',
            self::STATUS_INIT => 'Init',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_FAILED => 'Falide',
            self::STATUS_SUCCESS => 'Success',
        ];
    }

    public function getText()
    {
        return $this->box->code.$this->unique_id;
    }

    // 寻找 Item产品 数据表
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id'])->via('item');
    }

    // 寻找 Box盒子 数据表
    public function getBox()
    {
        return $this->hasOne(Box::class, ['id' => 'box_id']);
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id'])->via('box');
    }

    public function getPricing()
    {
        $num = number_format($this->sell_price, 2);

        return 'RM '.$num;
    }

    //Change Array to String
    // public function _toString()
    // {
    //     $arr = [
    //         'Store Name' => $this->store->name,
    //         'Address'=> $this->store->address,
    //         'Transaction ID' => $this->id,
    //         'Purchased Time' => $this->updated_at,
    //         'Box' => $this->box->code,
    //         'Item' => $this->item->name,
    //     ];

    //     //对数组中的每个元素应用用户自定义函数
    //     array_walk($arr,
    //         function (&$v, $k)
    //         {
    //             $v = $k.':'.$v;
    //         }
    //     );

    //     return implode(',', $arr);
    // }

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

        return false;
    }

    // 交易状态：购买成功
    public function success()
    {
        if ($this->status != SaleRecord::STATUS_FAILED)
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


    public function executeUpdateStatus()
    {
        if ($this->getIsFinalStatus())
        {
            return false;
        }
        return $this->queryPayAndGoOrderAPI();
    }

    private function getIsFinalStatus()
    {
        if ($this->status == self::STATUS_SUCCESS)
        {
            return true;
        }

        if ($this->status == self::STATUS_FAILED)
        {
            return true;
        }

        return false;
    }

    private function queryPayAndGoOrderAPI()
    {
        $data =  Yii::$app->payandgo->checkOrder($this->unique_id);

        if ($data)
        {
            $data = json_decode($data,true);
            $orderStatus = ArrayHelper::getValue($data, 'data.status', null);

            if (empty($orderStatus))
            {
                if (time() - $this->created_at > 60)
                {
                    return $this->failed();
                }

                return false;
            }

            if ($this->getIsFinalStatus())
            {
                return false;
            }

            if (Yii::$app->payandgo->getIsFinalStatus($orderStatus))
            {
                if (Yii::$app->payandgo->getIsPaymentSuccess($orderStatus))
                {
                    return $this->success();
                }

                if (Yii::$app->payandgo->getIsPaymentFailed($orderStatus))
               {
                   return $this->failed();
               }

               if (Yii::$app->payandgo->getIsPaymentPending($orderStatus))
               {
                   return $this->pending();
               }

            }

            if (Yii::$app->payandgo->getIsInitStatus($orderStatus))
            {
                if (time() - $this->created_at > 120) {
                    return $this->failed();
                }

                return false;
            }

            return false;
        }

        return false;
    }

    public function updateReference($reference_number)
    {
        $this->unique_id = $reference_number;
        $this->save();
    }

    public function getStatus()
    {
        return [
            ''  => 'All',
            '10' => 'Success',
            '9' => 'Pending',
            '8' => 'Failed',
            '0' => 'Init'
        ];
    }
}
