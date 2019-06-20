<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operator".
 *
 * @property int $Operator_ID
 * @property string $Operator_name
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
            [['Operator_name'], 'required'],
            [['Operator_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Operator_ID' => 'Operator ID',
            'Operator_name' => 'Operator Name',
        ];
    }
}
