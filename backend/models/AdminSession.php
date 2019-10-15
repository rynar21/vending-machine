<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_admin_session".
 *
 * @property int $session_id
 * @property int $id
 * @property string $session_token
 */
class AdminSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_admin_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'session_token'], 'required'],
            [['id'], 'integer'],
            [['session_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'session_id' => 'Session ID',
            'id' => 'ID',
            'session_token' => 'Session Token',
        ];
    }
}
