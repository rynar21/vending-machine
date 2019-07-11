<?php

namespace common\models;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'box_id'], 'required'],
            [['price'], 'number'],
            [['box_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'box_id' => 'Box ID',
        ];
    }

    public function getRecord()
    {
      return $this->hasOne(SaleRecord::className(), ['item_id'=>'id']);
    }

    public function getBox()
    {
        return $this->hasOne(Box::className(), ['box_id' => 'box_id']);
    }

    public function getStore()
    {
        return $this->hasOne(Store::className(), ['store_id' => 'box_id'])->via('box');
    }
}
