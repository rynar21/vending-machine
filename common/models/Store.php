<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $store_id
 * @property string $store_name
 * @property string $store_description
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_name'], 'required'],
            [['store_name', 'store_description'], 'string', 'max' => 255],
            [['store_contact'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'store_id' => 'Store ID',
            'store_name' => 'Store Name',
            'store_description' => 'Store Description',
            'store_contact' => 'Store Contact',
        ];
    }
}
