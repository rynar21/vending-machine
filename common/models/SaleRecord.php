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
    const STATUS_PENDING = 9;    //购买中
    const STATUS_SUCCESS = 10;   //购买成功
    const STATUS_FAILED = 0，8;  //购买失败
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
            [['box_id', 'item_id', 'trans_id'], 'required'],
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
}
