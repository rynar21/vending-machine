<?php
// Box盒子 信息 数据表
// Last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Queue;
/**
 * This is the model class for table "box".
 * @property int $id
 * @property int $code
 * @property int $status
 * @property int $store_id

 */
class Box extends \yii\db\ActiveRecord
{

    public $prefix;
    public $text;

    //盒子状态
    const BOX_STATUS_AVAILABLE = 1;      // 盒子可用/包含产品
    const BOX_STATUS_NOT_AVAILABLE = 2;  // 盒子不可用/
    const BOX_STATUS_LOCK = 0;  //锁住盒子

    // 数据表名称
    public static function tableName()
    {
        return 'box';
    }

    // 数据表 属性 规则
    public function rules()
    {
        return [
            [['code', 'store_id'], 'integer'],
            [['code'], 'required'],
            [['name'],'safe'],
            [['status'], 'default', 'value' => self::BOX_STATUS_AVAILABLE],
            [['hardware_id'],'string'],
        ];
    }

    // 自带 YII 时间添加功能
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getStore_id()
    {
        if (!empty($this->store->id))
        {
            return $this->store_id = $this->store->id;
        }

        return null;

    }

    // 数据表 属性 标注
    public function attributeLabels()
    {
        return [
            'id' => 'Box ID',
            'code' => 'Box Code',
            'status' => 'Box Status',
            'name'=>'Item Name',
            'store_id' => 'Store ID',
        ];
    }

    public function getAction()
   {
       if ($this->item) {
           return Html::a('Modify', ['/item/update', 'id' => $this->item->id], ['class' => 'btn btn-success']);
       } else {
           return Html::a('Restock', ['item/create', 'id' => $this->id], ['class' => 'btn btn-primary']);
       }
   }

    // 状态属性 以文字 展示
    public function getStatusText()
    {
        if($this->status == 0)
        {
            // 如果 Box盒子 包含 Item产品
            if($this->item)
            {
                $text = "Available"; // 盒子包含产品
                $this->status = self::BOX_STATUS_AVAILABLE;
                $this->save();
            }
            // 相反：如果 Box盒子 没有包含 Item产品
            if (!($this->item)) {
                $text = "Not Available"; // 盒子为空
                $this->status = self::BOX_STATUS_NOT_AVAILABLE;
                $this->save();
            }

            else {
                $text = "Lock box"; // 盒子为空
                $this->status = self::BOX_STATUS_LOCK;
                $this->save();
            }

        }
        else
        {
            // 如果 Box盒子 包含 Item产品
            if($this->item)
            {
                $text = "Available"; // 盒子包含产品
                $this->status = self::BOX_STATUS_AVAILABLE;
                $this->save();
            }
            // 相反：如果 Box盒子 没有包含 Item产品
            else
            {
                $text = "Not Available"; // 盒子为空
                $this->status = self::BOX_STATUS_NOT_AVAILABLE;
                $this->save();
            }
        }

        return $text;
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getItem()
    {
        return $this->hasOne(Item::class, ['box_id' => 'id'])
            ->where(['item.status' => [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]]); //用户体验
    }

    // 寻找 Item 产品 数据表
    public function getItems()
    {
        return $this->hasMany(Item::class, ['box_id' => 'id']);

    }

    public function getAvailableItems()
    {
        return $this->getItems()->orderBy(['id' => SORT_DESC])
        ->where(['item.status' => [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]])
        ->limit(1);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id'])->via('item');
    }

    // 判断 盒子 是否包含 产品 >> 连接 Item数据表 功能
    public function getBoxcode()
    {
        if(empty($this->store->prefix))
        {
            $text = $this->code;
        }
        else
        {
            $text = $this->store->prefix.$this->code; // 盒子包含产品
        }

        return $text;
    }

    public function getPrice()
    {
        if($this->item)
        {
            return $this->item->price;
        }

        return null;
    }

    public static function previousItem($store_id,$box_id)
    {
        $item = Item::find()->where([
            'store_id' => $store_id,
            'box_id' => $box_id,
            'status' => Item::STATUS_SOLD,
        ])->orderBy([
            'created_at' => SORT_DESC,
        ])->one();

        if ($item)
        {
            return
            [
                'item_name' => $item->name,
                'sku'   => $item->sku
            ];
        }
        return  false;
    }

}
