<?php
// Item产品 信息 数据表
// Last Modified: 04/08/2019
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
    // 产品 添加的初始值 & 交易失败
    const STATUS_AVAILABLE = 0;         // 对应 SaleRecord::STATUS_FAILED
    // 产品 购买当中
    const STATUS_LOCKED = 9;            // 对应 SaleRecord::STATUS_PENDING
    // 产品 交易成功
    const STATUS_SOLD = 10;             // 对应 SaleRecord::STATUS_SUCCESS

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

    // 数据表 属性 规则
    public function rules()
    {
        return [
            [['box_id', 'product_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['price'], 'number'],
            [['store_id', 'product_id'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_AVAILABLE],

        ];
    }

    // 聚标 属性 标注
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Created Time',
            'updated_at' => 'Updated Time',
            'box_id' => 'Box ID',
            'store_id'=> 'Store ID',
            'product_id'=> 'Product ID'
        ];
    }

    // public String quoteApostrophe(String input) {
    // if (input != null)
    //     return input.replaceAll("[\']", "&rsquo;");
    // else
    //     return null;
    // }
    public function getImage()
    {

        if (!empty($this->product->image)) {
            return $this->product->image;
        }
        else {
            return null;
        }
    }

    public function getName()
    {
        if (!empty($this->product->name)) {
            return $this->product->name;
        }
        else {
            return null;
        }
    }

    public function getStore_id()
    {
        if (!empty($this->box->store_id)) {
            return $this->box->store_id;
        }
        else {
            return null;
        }
    }


    // 状态属性 以文字展示
    public function getStatusText()
    {
        switch ($this->status)
        {
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



    // 以 价格格式 显示 Item产品价格
    public function getPricing()
    {
        $num = number_format($this->price, 2);
        return 'RM '.$num;
    }

    // 搜索 对应产品的 Store商店
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['store_id' => 'box_id'])->via('box');
    }

    // 搜索 对应产品的 Box盒子
    public function getBox()
    {
      return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    // 搜索 对应产品的 Product产品
    public function getProduct()
    {
      return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
