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
            [['code', 'store_id'], 'integer'],
            [['code'], 'required'],
        ];
    }

    // YII: 自带
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
        ];
    }

    public function getBoxes_count()
    {
        return Box::find()->where(['store_id'=> $id])->count();
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['box_id'=>'id'])
        ->orderBy(['id' => SORT_DESC])
        ->where(['status' => [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]])
        ->limit(1);
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['box_id'=>'id'])
        ->orderBy(['id' => SORT_DESC])
        ->where(['status' => [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]])
        ->limit(1);
    }

    public function getActiveItem()
    {
        return Item::find()->where(['status' => [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED]]);
    }
}
