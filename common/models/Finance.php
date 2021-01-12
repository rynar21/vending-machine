<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "finance".
 *
 * @property int $id
 * @property string $date
 * @property int $quantity_of_order
 * @property float $total_earn
 * @property float $gross_profit
 * @property float $net_profit
 * @property int $created_at
 * @property int $updated_at
 */
class Finance extends \yii\db\ActiveRecord
{
    const FINANCE_ININIAL_VALUE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance';
    }

    // YII 自带时间值 功能
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'quantity_of_order', 'total_earn', 'gross_profit', 'net_profit'], 'required'],
            [['quantity_of_order', 'created_at', 'updated_at'], 'integer'],
            [['total_earn', 'gross_profit', 'net_profit'], 'number'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'quantity_of_order' => 'Quantity Of Order',
            'total_earn' => 'Total Earn',
            'gross_profit' => 'Gross Profit',
            'net_profit' => 'Net Profit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
}
