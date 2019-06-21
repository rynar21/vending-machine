<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operator".
 *
 * @property int $operator_id
 * @property string $operator_name
 */
class Operator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operator_name'], 'required'],
            [['operator_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'operator_id' => 'Operator ID',
            'operator_name' => 'Operator Name',
        ];
    }
}
