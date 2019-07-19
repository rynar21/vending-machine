<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $details
 * @property int $created_at
 * @property int $updated_at
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['created_at', 'updated_at'], 'required'],
            // [['created_at', 'updated_at'], 'integer'],
            [['details'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'details' => 'Details',
            'created_at' => 'Created Time',
            'updated_at' => 'Updated Time',
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
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
