<?php
// Box盒子 信息 数据表
// Last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "box".
 * @property int $id
 * @property int $code
 * @property int $status
 * @property int $store_id

 */
class Box extends \yii\db\ActiveRecord
{
    public $number;
    public $prefix;

      //盒子状态
      const BOX_STATUS_AVAILABLE = 2;       // 盒子为空
      const BOX_STATUS_NOT_AVAILABLE = 1;   // 盒子包含产品

    // 数据表名称
    public static function tableName()
    {
        return 'box';
    }

    // 数据表 属性 规则
    public function rules()
    {
        return [
            [['number', 'store_id'], 'integer'],
            // [['prefix'], 'safe'],
            [['number'], 'required'],
            [['status'], 'default', 'value' => self::BOX_STATUS_AVAILABLE],
        ];
    }

    // 自带 YII 时间添加功能
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    public function getStore_id()
    {
        if (!empty($this->store->id)) {
            return $this->store_id=$this->store->id;
        }
        else {
            return null;
        }
    }

    // 数据表 属性 标注
    public function attributeLabels()
    {
        return [
            'id' => 'Box ID',
            'code' => 'Box Code',
            'status' => 'Box Status',
            'store_id' => 'Store ID',
        ];
    }

    // 状态属性 以文字 展示
    public function getStatusText()
    {
        if($this->status)
        {
            // 如果 Box盒子 包含 Item产品
            if($this->item)
            {
                $text = "Available"; // 盒子包含产品
                $this->status = self::BOX_STATUS_NOT_AVAILABLE;
                $this->save();
            }
            // 相反：如果 Box盒子 没有包含 Item产品
            else
            {
                $text = "Not Available"; // 盒子为空
                $this->status = self::BOX_STATUS_AVAILABLE;
                $this->save();
            }
        }
        return $text;
    }

    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id'=>'store_id']);
    }

    // 寻找 Item产品 数据表
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['box_id'=>'id'])
        ->orderBy(['id' => SORT_DESC])
        ->where(['status' => [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]])//用户体验
        ->limit(1);
    }

    // 寻找 Item 产品 数据表
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['box_id'=>'id'])
        ->orderBy(['id' => SORT_DESC])
        ->where(['status' => [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]])
        ->limit(1);
    }

    // 判断 盒子 是否包含 产品 >> 连接 Item数据表 功能
    public function getAction()
    {
        // 如果 Box盒子 包含 Item产品
        if ($this->item)
        {
            // 修改 产品 信息
            return Html::a('Modify Item', ['/item/update', 'id' => $this->item->id], ['class' => 'btn btn-success']);
        }
        // 相反：Box盒子 没有包含 Item产品
        else
        {
            // 添加新Item产品
            return Html::a('Add Item', ['item/create', 'id' => $this->id], ['class' => 'btn btn-primary']);
        }
    }

    public function beforeSave($insert)
    {
        $this->code = $this->number;
        return parent::beforeSave($insert);
    }

    public function getBoxcode()
    {
        if(empty($this->store->prefix))
        {
            $text = $this->code;
        }
        else
        {
            $text = $this->store->prefix.'-'.$this->code; // 盒子包含产品
        }
        return $text;
    }
}
