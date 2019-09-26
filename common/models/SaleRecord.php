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
    // 交易订单 状态
    const STATUS_PENDING = 9;    //购买中
    const STATUS_SUCCESS = 10;   //购买成功
    const STATUS_FAILED = 8;  //购买失败

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
            [['box_id', 'item_id'], 'required'],
            [['box_id', 'item_id'], 'integer'],
            [['sell_price'], 'number'],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
        ];
    }

    // 数据表 属性 标志
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'box_id' => 'Box ID',
            'item_id' => 'Item ID',
            'status' => 'Status',
            'sell_price' => 'Price',
        ];
    }

    // 寻找 Item产品 数据表
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
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
    public function _toString(){
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
        if ($this->status !=SaleRecord::STATUS_SUCCESS && $this->status !=SaleRecord::STATUS_FAILED)
        {
           // 更新 Item产品 的状态属性 为购买当中
           $this->status=SaleRecord::STATUS_PENDING;
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
             // 更新 Box盒子 的状态属性 为空
             $this->box->status = Box::BOX_STATUS_AVAILABLE;
             $this->box->save();
             // 更新 Item产品 的状态属性 为已售出
             $this->item->status =  Item::STATUS_SOLD;
             $this->item->save();
         }

         return $this->save() && $this->item->save() && $this->box->save() && Yii::$app->slack->curlPost([
             'data' =>
             [
                 'text' => $this->_toString()

             ],
             // 'url' => "https://ry92.requestcatcher.com/",
         ]);
    }

    // 交易状态： 购买失败
    public function failed()
    {
        if ($this->status == SaleRecord::STATUS_PENDING)
        {
            // 更新 Item产品 的状态属性 为购买失败/初始值
            $this->status = SaleRecord::STATUS_FAILED;
            $this->save();

            if ($this->item->status != Item::STATUS_SOLD)
            {
              $this->item->status = Item::STATUS_AVAILABLE;
              $this->item->save();
            }
         }
         return $this->save() && $this->item->save();
    }


    // public function curlPost($config){
    //     $url = ArrayHelper::getValue($config, 'url', 'https://hooks.slack.com/services/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');
    //     $data = ArrayHelper::getValue($config, 'data');
    //     $ch = curl_init();
    //
    //     curl_setopt($ch, CURLOPT_URL, $url); // set URL
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); //Set HTTP Header for POST request
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //Get data from browser
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); //set custom request method to POST
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  //To post a file
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //FALSE to stop cURL from verifying the peer's certificate
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //To check the existence of a common name in the SSL peer certificate
    //
    //     // grab URL and pass it to the browser
    //     $result = curl_exec($ch);
    //
    //     // Close cURL session handle || close cURL resource, and free up system resources
    //     curl_close($ch);
    // }

}
