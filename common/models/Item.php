<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property int $box_id
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

    /**
     * 连接数据库的表 ：item
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * YII 自带时间值 功能
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    public function getBox()
    {
      return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

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

    public function getPricing()
    {
        $num = number_format($this->price, 2);
        return 'RM '.$num;
    }

    public function getActiveItem()
    {
        Item::find()->where(['status' => self::STATUS_DEFAULT, self::STATUS_AVAILABLE]);
    }
}
