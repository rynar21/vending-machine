<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "box".
 *
 * @property int $box_id
 * @property int $box_code
 * @property int $box_status
 * @property int $store_id

 */
class Box extends \yii\db\ActiveRecord
{
    const STATUS_AVAILABLE = 1;
    const STATUS_UNAVAILABLE = 2;

    /**
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
    public static function tableName()
    {
        return 'box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'store_id', 'item_id'], 'integer'],
            [['code'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Box ID',
            'code' => 'Box Code',
            'status' => 'Box Status',
            'store_id' => 'Store ID',
            'item_id' => 'Item ID',
        ];
    }

    public function getStore()
    {
      return $this->hasOne(Store::className(), ['id'=>'store_id']);
    }

    public function getItem()
    {
      return $this->hasOne(Item::className(), ['box_id'=>'id']);
    }

    public function getActiveItem()
    {
        Item::find()->where(['status' => '']);
    }
}
