<?php

namespace common\models;

use yii;

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
            [['name','user_id'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Operator ID',
            'operator_name' => 'Operator Name',
        ];
    }
    public function  getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }
}
