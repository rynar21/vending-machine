<?php

namespace common\models;

use Yii;

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
    public function rules()
    {
        return [
            [['box_id', 'item_id', 'trans_id'], 'required'],
            [['box_id', 'item_id', 'trans_id', 'status'], 'integer'],
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
