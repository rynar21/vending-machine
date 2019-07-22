<?php
/*
    By: Melissa Ho
    21/07/2019
*/
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "item".
 * @property int $id
 * @property string $name
 * @property double $price
 * @property int $box_id
 * @property int $store_id
 * @property smallint $status
 * @property int $created_at
 * @property int $updated_at
 */
class Item extends \yii\db\ActiveRecord
{
    // 产品添加 初始值
    const STATUS_DEFAULT = 0;
    // 产品 交易失败
    const STATUS_AVAILABLE = 8; // SaleRecord::STATUS_FAILED
    // 产品 购买当中
    const STATUS_LOCKED = 9; // SaleRecord::STATUS_PENDING
    // 产品 交易成功
    const STATUS_SOLD = 10; // SaleRecord::STATUS_SUCCESS

    // 连接数据库的表 ：item
    public static function tableName()
    {
        return 'item';
    }

    // YII 自带时间值 功能
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    // 定义 属性
    public function rules()
    {
        return [
            [['name', 'price', 'box_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['price'], 'number'],
            [['box_id'], 'integer'],
            [['store_id'], 'integer'],
            [['image'], 'default', 'value' => ''],
            [['status'], 'default', 'value' => self::STATUS_DEFAULT],
        ];
    }

    // 标注 属性 名称
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Created Time',
            'updated_at' => 'Updated Time',
            'box_id' => 'Box ID',
            'store_id'=> 'Store ID'
        ];
    }
    // 搜索 对应产品的 盒子
    public function getBox()
    {
      return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    // 打印状态为文字
    public function getStatusText()
    {
        switch ($this->status) {
        case self::STATUS_DEFAULT:
            $text = "Available";
            break;
        case self::STATUS_AVAILABLE:
            $text = "Available";
            break;
        case self::STATUS_LOCKED:
            $text = "On Hold";
            break;
        case self::STATUS_SOLD:
            $text = "Sold";
            break;
        default:
            $text = "(Undefined)";
            break;
        }
        return $text;
    }

    // 打印 价格格式
    public function getPricing()
    {
        $num = number_format($this->price, 2);
        return 'RM '.$num;
    }

}
