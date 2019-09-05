<?php
// SaleRecord交易订单 信息 数据表
// last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
        return $this->hasOne(Store::className(), ['id' => 'id'])->via('box');
    }

    public function getPricing()
    {
        $num = number_format($this->sell_price, 2);
        return 'RM '.$num;
    }

    // 更新 对应的数据表里的 属性
    // 交易状态： 购买当中
    public function pending()
    {
        // 更新 Item产品 的状态属性 为购买当中
        $this->status=SaleRecord::STATUS_PENDING;
        $this->item->status = Item::STATUS_LOCKED;
        $this->item->save();
    }

    // 交易状态：购买成功
    public function success()
    {
        // 更新 Item产品 的状态属性 为购买成功
        $this->status = SaleRecord::STATUS_SUCCESS;
        $this->item->status = Item::STATUS_SOLD;
        $this->item->save();

        // 更新 Box盒子 的状态属性 为空
        $this->box->status = Box::BOX_STATUS_AVAILABLE;
        $this->box->save();
    }

    // 交易状态： 购买失败
    public function failed()
    {
        // 更新 Item产品 的状态属性 为购买失败/初始值
        $this->status = SaleRecord::STATUS_FAILED;
        $this->item->status = Item::STATUS_AVAILABLE;
        $this->item->save();
    }

}
