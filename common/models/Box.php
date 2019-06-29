<?php

namespace common\models;

use Yii;

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
            [['box_code', 'box_status', 'store_id'], 'integer'],
            [['box_code'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'box_id' => 'Box ID',
            'box_code' => 'Box Code',
            'box_status' => 'Box Status',
            'store_id' => 'Store ID',
        ];
    }

    public function getStores()
    {
      return $this->hasOne(Store::className(), ['store_id'=>'store_id']);
    }
    public function getItems()
    {
      return $this->hasOne(Item::className(), ['box_id'=>'box_id']);
    }
}
