<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sale_record".
 *
 * @property int $id
 * @property int $box_id
 * @property int $item_id
 * @property int $trans_id
 * @property int $status
 */
class SaleRecord extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 9;
    const STATUS_SUCCESS = 10;
    const STATUS_FAILED = 8;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_record';
    }

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
    public function rules()
    {
        return [
            [['box_id', 'item_id'], 'required'],
            [['box_id', 'item_id', 'trans_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'box_id' => 'Box ID',
            'item_id' => 'Item ID',
            'trans_id' => 'Trans ID',
            'status' => 'Status',
        ];
    }

    public function pending()
    {
        $this->updateAttributes([
            'status' => static::STATUS_PENDING,
        ]);
        $this->item->updateAttributes([
            'status' => Item::STATUS_LOCKED,
        ]);
    }

    public function success()
    {
        $this->updateAttributes([
            'status' => static::STATUS_SUCCESS,
        ]);
        $this->item->updateAttributes([
            'status' => Item::STATUS_SOLD,
        ]);
    }

    public function failed()
    {
        $this->updateAttributes([
            'status' => static::STATUS_FAILED,
        ]);
        $this->item->updateAttributes([
            'status' => Item::STATUS_ACTIVE,
        ]);
    }
}
